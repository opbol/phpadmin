dashboard = {};

dashboard.initChart = function () {
    var data = {
        labels: labels,
        datasets: [
            {
                label: "Activity (last 30 days)",
                fillColor: "#605ca8",
                strokeColor: "rgba(0,0,0,0.0)",
                pointColor: "#fff",
                pointStrokeColor: "#605ca8",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "#605ca8",
                data: activities
            }
        ]
    };

    var ctx = document.getElementById("myChart").getContext("2d");
    var myLineChart = new Chart(ctx).Line(data, {
        responsive: true,
        maintainAspectRatio: false,
        tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> <%= value == 1 ? 'action' : 'actions' %>",
    });
};

$(document).ready(function () {
    dashboard.initChart();
});