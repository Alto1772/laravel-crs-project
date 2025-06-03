// import "lodash/lodash";
import ApexCharts from "apexcharts";
import * as ACHelpers from "flyonui/dist/js/helper-apexcharts";

// Register ApexCharts globally in the window object to make it accessible in other parts of the application.
window.ApexCharts = ApexCharts;

// Import all helper functions from FlyonUI's helper-apexcharts module.
Object.assign(window, ACHelpers);
