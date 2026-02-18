@extends('layouts.app')

@section('content')
<div class="record-wrapper flex flex-col gap-5 h-full">
  <h2 class="text-xl font-bold">ホーム</h2>

  <div class="grid flex-1 grid-cols-2 grid-rows-2 gap-5 min-h-0">

    <div class="card bg-white p-5 rounded-[10px] shadow-md flex flex-col min-h-0">
      <h3 class="font-bold">食事</h3>
      <div class="chart-container flex-1 relative min-h-0">
        <canvas id="foodChart" class="absolute inset-0 w-full h-full block"></canvas>
      </div>
    </div>

    <div class="card bg-white p-5 rounded-[10px] shadow-md flex flex-col min-h-0">
      <h3 class="font-bold">睡眠</h3>
      <div class="chart-container flex-1 relative min-h-0">
        <canvas id="sleepChart" class="absolute inset-0 w-full h-full block"></canvas>
      </div>
    </div>

    <div class="card bg-white p-5 rounded-[10px] shadow-md flex flex-col min-h-0">
      <h3 class="font-bold">運動</h3>
      <div class="chart-container flex-1 relative min-h-0">
        <canvas id="exerciseChart" class="absolute inset-0 w-full h-full block"></canvas>
      </div>
    </div>

    <div class="card bg-white p-5 rounded-[10px] shadow-md flex flex-col min-h-0">
      <h3 class="font-bold">勉強</h3>
      <div class="chart-container flex-1 relative min-h-0">
        <canvas id="studyChart" class="absolute inset-0 w-full h-full block"></canvas>
      </div>
    </div>
  </div>
</div>

<script>
  const data = @json($records);

  function drawChart(canvasId, category, label){
    const chartData = data
      .filter(r => r.category === category)
      .map(r => ({ x: r.date, y: r.value }));

    const ctx = document.getElementById(canvasId).getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: { datasets: [{ label: label, data: chartData, tension: 0.3 }] },
      options: { parsing: { xAxisKey: 'x', yAxisKey: 'y' } }
    });
  }

  // 各カテゴリ描画
  drawChart('foodChart', 'food', '食事');
  drawChart('sleepChart', 'sleep', '睡眠');
  drawChart('exerciseChart', 'exercise', '運動');
  drawChart('studyChart', 'study', '勉強');
</script>
@endsection