class ChartsClass {
    
    constructor(avg, date, classAvg, classDate, avgPlus, avgMinus) {
        this.avg = avg;
        this.date = date;
        this.classAvg = classAvg;
        this.classDate = classDate;
        this.avgPlus = avgPlus;
        this.avgMinus = avgMinus;

        this.chart1();
        this.chart2();
        this.chart3();
    }

    //===========================
    //       Avg by test
    //===========================

    chart1 () {        
        
        var myChart1 = echarts.init(document.getElementById('testChart'));
        
        var option = {

            title: {
                text: 'Moyennes des évaluations'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['Moyenne']
            },
            xAxis: {
                data: this.avg
            },
            yAxis: {
                max: 'dataMax',
                min: 'dataMin'
            },
            series: [{
                name: 'Moyenne',
                type: 'line',
                data: this.date,
                areaStyle: {
                    normal: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgb(255, 158, 68)'
                        }, {
                            offset: 1,
                            color: 'rgb(255, 70, 131)'
                        }])
                    }
                },
                markLine: {
                    silent: true,
                    data: [{
                        yAxis: 5
                    }]
                }
            }]
        };

        
        myChart1.setOption(option);
    }

    //===========================
    //       Avg by test
    //===========================

    chart2 () {        
        
        var myChart2 = echarts.init(document.getElementById('classChart'));
        
        var option2 = {

            title: {
                text: 'Moyenne de la classe en fonction des évaluations'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['Moyenne']
            },
            xAxis: {
                data: this.classDate
            },
            yAxis: {
                max: 10
            },
            series: [{
                name: 'Moyenne',
                type: 'line',
                data: this.classAvg,
                areaStyle: {
                    normal: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgb(255, 158, 68)'
                        }, {
                            offset: 1,
                            color: 'rgb(255, 70, 131)'
                        }])
                    }
                },
                markLine: {
                    silent: true,
                    data: [{
                        yAxis: 5
                    }]
                }
            }]
        };

        
        myChart2.setOption(option2);
    }

    chart3 () {        
        
        var myChart3 = echarts.init(document.getElementById('avgChart'));
        
        var option3 = {
            title: {
                text: 'Evaluation par rapport à la moyenne'
            },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'horizontal',
                    data: ["Sousla moyenne", "Au dessus de la moyenne"]
                },
                series : [
                    {
                        name: 'Evaluation',
                        type: 'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data:[
                            {value:this.avgMinus, name:'Sous la moyenne'},
                            {value:this.avgPlus, name:'Au dessus de la moyenne'}
                        ],
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            
        };

        
        myChart3.setOption(option3);
    }
}

