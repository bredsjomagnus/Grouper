@extends('layouts.standard')

@section('title', 'Event overview')

@section('leftsidepanel')
@include('includes.leftsidepanel')
@endsection

@section('content')
   <script type="text/javascript" src="{{ asset('js/fusioncharts.js') }}"></script>
   <script type="text/javascript" src="{{ asset('js/fusioncharts.charts.js') }}"></script>
   <script type="text/javascript" src="{{ asset('js/themes/fusioncharts.theme.fint.js') }}"></script>

    <?php

	$barChart = new FusionCharts("bar2d", "event-choices" , 600, 400, "chart1-container", "json",
		' {
			"chart": {
				"caption": "Choices - percent",
				"numberSuffix": "%",
				"paletteColors": "#876EA1",
				"useplotgradientcolor": "0",
				"plotBorderAlpha": "0",
				"bgColor": "#FFFFFFF",
				"canvasBgColor": "#FFFFFF",
				"showValues":"1",
				"showCanvasBorder": "0",
				"showBorder": "0",
				"divLineColor": "#DCDCDC",
				"alternateHGridColor": "#DCDCDC",
				"labelDisplay": "auto",
				"baseFont": "Assistant",
				"baseFontColor": "#153957",
				"outCnvBaseFont": "Assistant",
				"outCnvBaseFontColor": "#8A8A8A",
				"baseFontSize": "13",
				"outCnvBaseFontSize": "13",
				"yAxisMinValue":"40",
				"labelFontColor": "#8A8A8A",
				"captionFontColor": "#153957",
				"captionFontBold": "1",
				"captionFontSize": "20",
				"subCaptionFontColor": "#153957",
				"subCaptionfontSize": "17",
				"subCaptionFontBold": "0",
				"captionPadding": "20",
				"valueFontBold": "0",
				"showAxisLines": "1",
				"yAxisLineColor": "#DCDCDC",
				"xAxisLineColor": "#DCDCDC",
				"xAxisLineAlpha": "15",
				"yAxisLineAlpha": "15",
				"toolTipPadding": "7",
				"toolTipBorderColor": "#DCDCDC",
				"toolTipBorderThickness": "0",
				"toolTipBorderRadius": "2",
				"showShadow": "0",
				"toolTipBgColor": "#153957",
				"theme": "fint"
			  },
			'.$valuespercent.'
		}');
		$backurl = url("/events/edit/".$eventid);
        $barChart->render();
    ?>
	<?php  ?>
	<div class="row">
		<br>
		<br>
		<a class='btn btn-default' href={{ $backurl }}>Tillbaka</a>
	</div>

      <center><div id="chart1-container"></div></center>
@endsection
