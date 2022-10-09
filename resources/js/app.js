// Mazer internal JS. Include this in your project to get

import "./components/dark";

import PerfectScrollbar from "perfect-scrollbar";
import Sidebar from "./components/sidebar";

/**
 * Initialize Perfect Scrollbar for Sidebar
 */
const container = document.querySelector(".sidebar-wrapper");
const ps = new PerfectScrollbar(container, {
    wheelPropagation: false,
});

/**
 * Create Sidebar Wrapper
 */
let sidebarEl = document.getElementById("sidebar");
if (sidebarEl) {
    window.sidebar = new Sidebar(sidebarEl);
}
