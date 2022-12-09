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

    public static function getPatientWithVillage($id)
    {
        return Patient::with('village')->find($id);
    }

    public static function getPatientsForReport2($startDate, $endDate, $minAge, $maxAge)
    {
        $query = <<<EOD
        SELECT id FROM (
            SELECT *, FLOOR (DATEDIFF(NOW(),birthday) /365.2425) AS 'age' FROM patients
            WHERE id IN (
                SELECT DISTINCT(patient_id) FROM consultations
                WHERE DATE > "$startDate"
                AND DATE < "$endDate"
                ORDER BY patient_id
            )
        ) AS p
        WHERE age > $minAge AND age < $maxAge
        EOD;

        $patientList = DB::select(DB::raw($query));

        $patientsId = array_column($patientList, 'id');

        return (new static)::with(['consultations' => function ($query) use ($endDate) {
            $query->whereBetween('date', [Carbon::parse($endDate)->subYear(), $endDate])->orderBy('date', 'asc');
        }])->whereIn('id', $patientsId)->get();
    }

    public static function getPatientsForReport3($startDate, $endDate, $minAge, $maxAge)
    {
        return Patient::with([
            'consultations' => function ($query) use ($endDate) {
                $query->select('id', 'patient_id', 'date', 'systole', 'diastole')
                    ->whereBetween('date', [Carbon::parse($endDate)->endOfMonth()->subYear(), $endDate])
                    ->orderBy('date', 'asc');
            }
        ])->select('id', 'sex', 'village_id')
            ->whereRaw("FLOOR (DATEDIFF(NOW(),birthday) /365.2425) >= ?", [$minAge])
            ->whereRaw("FLOOR (DATEDIFF(NOW(),birthday) /365.2425) <= ?", [$maxAge])
            ->whereRelation('consultations', 'date', '>', $startDate)
            ->whereRelation('consultations', 'date', '<', $endDate)
            ->get();
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
                date
                between date_add(date_sub(last_day(now()), interval 3 month), interval 1 day)
                and last_day(now())
                ) cm
            group by patient_id
            ) mc on patients.id = mc.patient_id
        left join 
            (
            select distinct patient_id, systole, diastole
            from consultations 
            where 
            patient_id = $id and
            date between date_add(date_sub(last_day(now()), interval 3 month), interval 1 day)
            and last_day(now())
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
                        date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
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

    public static function getPatientsForReport()
    {
        $query = <<<EOD
        select id, village_id, sex, ifnull(monthcount, 0) as count_month, 
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
                where date
                between date_add(date_sub(last_day(now()), interval 3 month), interval 1 day)
                and last_day(now())
                ) cm
            group by patient_id
            ) mc on patients.id = mc.patient_id
        left join 
            (
            select distinct patient_id, systole, diastole
            from consultations 
            where date between date_add(date_sub(last_day(now()), interval 3 month), interval 1 day)
            and last_day(now())
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
                        where date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
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
