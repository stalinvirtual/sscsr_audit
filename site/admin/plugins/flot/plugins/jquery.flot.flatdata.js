

(function ($) {
    'use strict';

    function process1DRawData(plot, series, data, datapoints) {
        if (series.flatdata === true) {
            var start = series.start || 0;
            var step = typeof series.step === 'number' ? series.step : 1;
            datapoints.pointsize = 2;
            for (var i = 0, j = 0; i < data.length; i++, j += 2) {
                datapoints.points[j] = start + (i * step);
                datapoints.points[j + 1] = data[i];
            }
            if (datapoints.points !== undefined) {
                datapoints.points.length = data.length * 2;
            } else {
                datapoints.points = [];
            }
        }
    }

    $.plot.plugins.push({
        init: function(plot) {
            plot.hooks.processRawData.push(process1DRawData);
        },
        name: 'flatdata',
        version: '0.0.2'
    });
})(jQuery);
