// Importa los módulos necesarios de Chart.js
import Chart from 'chart.js/auto';
import { randomScalingFactor } from 'chart.js/helpers';

// Obtén la referencia al elemento canvas de la gráfica
const canvas = document.getElementById('myChart');

// Crea un objeto Chart inicial con los datos y opciones deseados
const ctx = canvas.getContext('2d');
const initialData = {
  labels: ['Label 1', 'Label 2', 'Label 3'],
  datasets: [{
    label: 'Dataset',
    data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderColor: 'rgba(75, 192, 192, 1)',
    borderWidth: 1
  }]
};
const chart = new Chart(ctx, {
  type: 'line',
  data: initialData,
  options: {
    animation: {
      duration: 0 // Desactiva la animación inicial
    }
  }
});

// Define una función para actualizar los datos de la gráfica
function updateChart() {
  // Genera nuevos datos aleatorios y agrega el último dato al final
  const newData = {
    labels: [...chart.data.labels.slice(1), `Label ${chart.data.labels.length + 1}`],
    datasets: [{
      label: 'Dataset',
      data: [...chart.data.datasets[0].data.slice(1), randomScalingFactor()],
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 1
    }]
  };

  // Actualiza los datos de la gráfica y renderízala con animación
  chart.data = newData;
  chart.update({
    duration: 0, // Desactiva la animación de actualización
    easing: 'linear' // Utiliza una animación lineal continua
  });
}

// Actualiza la gráfica en bucle infinito
function animateChart() {
  updateChart();
  requestAnimationFrame(animateChart);
}

animateChart();
