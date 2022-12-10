<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'medical_record_number', 'nik', 'sex', 'birthday', 'address', 'village_id', 'job', 'phone_number'];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function getPatientDetail($id)
    {
        $query = <<<EOD
        select patients.id, patients.name, medical_record_number, nik, sex, birthday, address, 
            v.name as village_name, job, phone_number, ifnull(monthcount, 0) as count_month, 
            ifnull(max(systole), 0) as max_systole, ifnull(max(diastole), 0) as max_diastole,
            if(ifnull(max(systole), 0) < 140 and ifnull(max(diastole), 0) < 90
            and ifnull(monthcount, 0) = 3, 0, 1) as is_hypertension,
            maks, if(maks >= 3, 1, 0) as is_routine
        from patients 
        left join
            (
            select patient_id, count(month) as monthcount
            from
                (
                select distinct patient_id, month(date) as month
                from consultations 
                where 
                patient_id = $id and
                date between date_add(last_day(date_sub(now(), interval 4 month)), interval 1 day)
                and last_day(date_sub(now(), interval 1 month))
                ) cm
            group by patient_id
            ) mc on patients.id = mc.patient_id
        left join 
            (
            select distinct patient_id, systole, diastole
            from consultations 
            where 
            patient_id = $id and
            date between date_add(last_day(date_sub(now(), interval 4 month)), interval 1 day)
            and last_day(date_sub(now(), interval 1 month))
            ) c on patients.id = c.patient_id
        left join
            (
            select patient_id, max(numMonths) as maks from (
            select patient_id, count(*) as numMonths
            from (select patient_id, ym, @ym, @person,
                        if(@person = patient_id  and @ym = ym - 1, @grp, @grp := @grp + 1) as grp,
                        @person := patient_id ,
                        @ym := ym
                from (select distinct patient_id, year(date)*12+month(date) as ym
                        from consultations r
                        where 
                        patient_id = $id and
                        date between date_add(last_day(date_sub(now(), interval 13 month)), interval 1 day)
                        and last_day(date_sub(now(), interval 1 month))
                    ) r cross join
                    (select @person := '', @ym := 0, @grp := 0) const
                order by 1, 2
                ) pym
            group by patient_id, grp
            ) gpym group by patient_id
            ) x on patients.id = x.patient_id
        left join
            (
            select id, name from villages
            ) v on patients.village_id = v.id
        where patients.id = $id
        group by patients.id
        EOD;

        return DB::selectOne(DB::raw($query));
    }

    public static function getPatientsForReport($type, $month, $year)
    {
        if ($type == 'monthly') {
            $date = Carbon::create($year, $month)->format('Y-m-d');
            $interval = 3;
        } else {
            $date = Carbon::create($year, 12)->format('Y-m-d');
            $interval = 12;
        }

        $query = <<<EOD
        select id, village_id, sex, ifnull(monthcount, 0) as count_month, 
            ifnull(max(systole), 0) as max_systole, ifnull(max(diastole), 0) as max_diastole,
            if(ifnull(max(systole), 0) < 140 and ifnull(max(diastole), 0) < 90
            and ifnull(monthcount, 0) = 3, 0, 1) as is_hypertension,
            maks, if(maks >= 3, 1, 0) as is_routine
        from patients
        right join 
            (
            select distinct patient_id, systole, diastole
            from consultations 
            where date between date_add(last_day(date_sub("$date", interval $interval month)), interval 1 day)
            and last_day("$date")
            ) c on patients.id = c.patient_id
        left join
            (
            select patient_id, count(month) as monthcount
            from
                (
                select distinct patient_id, month(date) as month
                from consultations 
                where date
                between date_add(last_day(date_sub("$date", interval 3 month)), interval 1 day)
                and last_day("$date")
                ) cm
            group by patient_id
            ) mc on patients.id = mc.patient_id
        left join
            (
            select patient_id, max(numMonths) as maks from (
            select patient_id, count(*) as numMonths
            from (select patient_id, ym, @ym, @person,
                        if(@person = patient_id  and @ym = ym - 1, @grp, @grp := @grp + 1) as grp,
                        @person := patient_id ,
                        @ym := ym
                from (select distinct patient_id, year(date)*12+month(date) as ym
                        from consultations r
                        where date between date_add(last_day(date_sub("$date", interval 12 month)), interval 1 day)
                        and last_day("$date")
                    ) r cross join
                    (select @person := '', @ym := 0, @grp := 0) const
                order by 1, 2
                ) pym
            group by patient_id, grp
            ) gpym group by patient_id
            ) x on patients.id = x.patient_id
        group by patients.id
        EOD;

        return collect(DB::select(DB::raw($query)));
    }
}
