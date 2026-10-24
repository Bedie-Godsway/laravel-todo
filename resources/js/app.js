import Swal from 'sweetalert2';

window.Swal = Swal;

const editForm = document.getElementById('editForm');

if (editForm) {
    editForm.addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to save these changes?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                editForm.submit();
            }
        });
    });
}



import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
window.Chart = Chart;

const chartCanvas = document.getElementById('statusChart');

if (chartCanvas) {
    const counts = {
        pending: Number(chartCanvas.dataset.pending),
        inProgress: Number(chartCanvas.dataset.inProgress),
        completed: Number(chartCanvas.dataset.completed),
        total: Number(chartCanvas.dataset.total),
    };

    console.log(counts);
    if (counts.total > 0) {
    new Chart(chartCanvas, {
        type: 'pie',
        data: {
            labels: ['Pending Tasks', 'Tasks in Progress', 'Completed Tasks'],
            datasets: [{
                data: [counts.pending, counts.inProgress, counts.completed],
                backgroundColor: ['#f59e0b', '#38bdf8', '#3bf00d'],
                borderColor: '#0F1521',
            }],
        },
        options: {
            plugins: {
                legend: { labels: { color: '#cbd5e1' } },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const share = (context.parsed / counts.total * 100).toFixed(1);
                            return `${context.label}: ${context.parsed} (${share}%)`;
                        },
                    },
                },
            },
        },
    });
    } 
}