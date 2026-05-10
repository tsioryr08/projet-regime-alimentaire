(function () {
  const data = window.__dashboardData || {};

  const objectiveLabels = (data.utilisateursParObjectif || []).map(item => item.objectif || 'Inconnu');
  const objectiveValues = (data.utilisateursParObjectif || []).map(item => Number(item.total || 0));

  // limit to top 8 régimes to avoid overcrowding the bar chart
  const regimesRaw = (data.regimesPopulaires || []).slice(0, 8);
  const regimeLabels = regimesRaw.map(item => item.nom || 'Sans nom');
  const regimeValues = regimesRaw.map(item => Number(item.total || 0));

  const goldLabels = ['Gold', 'Non-Gold'];
  const goldData = { gold: 0, nonGold: 0 };
  (data.repartitionGold || []).forEach(item => {
    if (Number(item.is_gold) === 1) {
      goldData.gold = Number(item.total);
    } else {
      goldData.nonGold = Number(item.total);
    }
  });

  const gridColor = 'rgba(111,146,123,.12)';
  const labelColor = '#4b5a51';
  const chartPalette = ['#a9cdb1', '#f4c6d6', '#6f927b', '#c984a1', '#eef6ef', '#fff3f7', '#89b69e', '#dba4bb'];

  const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { labels: { color: labelColor, font: { family: 'Poppins', weight: '600' } } },
      tooltip: {
        backgroundColor: '#203026',
        titleColor: '#fff7fa',
        bodyColor: '#eef6ef',
        borderColor: '#6f927b',
        borderWidth: 1
      }
    },
    scales: {
      x: { ticks: { color: labelColor }, grid: { color: gridColor } },
      y: { ticks: { color: labelColor }, grid: { color: gridColor } }
    }
  };

  const objectiveCanvas = document.getElementById('chartObjectives');
  if (objectiveCanvas && window.Chart) {
    const hasObjectives = objectiveLabels.length && objectiveValues.reduce((a,b)=>a+b,0) > 0;
    new Chart(objectiveCanvas, {
      type: 'doughnut',
      data: {
        labels: hasObjectives ? objectiveLabels : ['Aucune donnée'],
        datasets: [{
          data: hasObjectives ? objectiveValues : [1],
          backgroundColor: hasObjectives ? chartPalette.slice(0, 3) : ['#eef6ef'],
          borderColor: '#ffffff',
          borderWidth: 4,
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        cutout: '58%',
        plugins: { legend: { position: 'bottom', labels: { color: labelColor, padding: 18, usePointStyle: true } } }
      }
    });
  }

  const regimeCanvas = document.getElementById('chartRegimes');
  if (regimeCanvas && window.Chart) {
    const hasRegimes = regimeLabels.length && regimeValues.reduce((a,b)=>a+b,0) > 0;
    new Chart(regimeCanvas, {
      type: 'bar',
      data: {
        labels: hasRegimes ? regimeLabels : ['Aucune donnée'],
        datasets: [{
          label: 'Suggestions',
          data: hasRegimes ? regimeValues : [1],
          backgroundColor: hasRegimes ? chartPalette : ['#eef6ef'],
          borderRadius: 14,
          borderSkipped: false,
          maxBarThickness: 42
        }]
      },
      options: {
        ...commonOptions,
        plugins: {
          ...commonOptions.plugins,
          legend: { display: false }
        },
        scales: {
          x: { ticks: { color: labelColor }, grid: { display: false } },
          y: { beginAtZero: true, ticks: { color: labelColor, precision: 0 }, grid: { color: gridColor } }
        }
      }
    });
  }

  const goldCanvas = document.getElementById('chartGold');
  if (goldCanvas && window.Chart) {
    const totalGold = goldData.gold + goldData.nonGold;
    const hasGold = totalGold > 0;
    new Chart(goldCanvas, {
      type: 'pie',
      data: {
        labels: hasGold ? goldLabels : ['Aucune donnée'],
        datasets: [{
          data: hasGold ? [goldData.gold, goldData.nonGold] : [1],
          backgroundColor: hasGold ? ['#c984a1', '#a9cdb1'] : ['#eef6ef'],
          borderColor: '#ffffff',
          borderWidth: 4,
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { color: labelColor, padding: 18, usePointStyle: true } } }
      }
    });
  }
})();
