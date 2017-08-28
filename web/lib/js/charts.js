class Charts {

    constructor(studentsList, values) {
        this.studentsList = studentsList;
        this.values = values;

        this.chart1();
        this.chart2();
        this.chart3();
    }

    toNumber (array) {
        for(var i=0; i<array.length; i++)
            array[i] = Number(array[i]);
        return array;
    }

    moyenne(array)
    {
        var n = array.length; 
        var somme = 0;
        for(var i=0; i<n; i++) {
            somme += array[i];
        }
                
        return somme/n; 
    }

    max(array)
    {
        var max = Math.max(...array)
        return max;   
    }

    min(array)
    {
        var min = Math.min(...array)
        return min;   
    }

    numOfMarks(array) {
        var numOfMarks = [0,0,0,0,0,0,0,0,0,0,0];

       

        array.forEach(function(element) {
            switch (element) {
                case 0:
                    numOfMarks [0] ++                    
                    break;

                case 1:
                    numOfMarks [1] ++
                    break;
                
                case 2:
                    numOfMarks [2] ++
                    break;
                
                case 3:
                    numOfMarks [3] ++
                    break;

                case 4:
                    numOfMarks [4] ++
                    break;

                case 5:
                    numOfMarks [5] ++
                    break;
                    
                case 6:
                    numOfMarks [6] ++
                    break;

                case 7:
                    numOfMarks [7] ++
                    break;

                case 8:
                    numOfMarks [8] ++
                    break;

                case 9:
                    numOfMarks [9] ++
                    break;

                case 10:
                    numOfMarks [10] ++
                    break;
            
                default:
                    break;
            }
        });    

        return numOfMarks;
    }

    //===========================
    // All Marks by Student Chart
    //===========================

    chart1 () {        
        
        var myChart1 = echarts.init(document.getElementById('chart1'));
        
        var option = {

            title: {
                text: 'Toutes les notes'
            },
            tooltip: {},
            legend: {
                data:['Notes']
            },
            xAxis: {
                data: this.studentsList
            },
            yAxis: {},
            series: [{
                name: 'Notes',
                type: 'bar',
                data: this.values
            }]
        };

        
        myChart1.setOption(option);
    }

    //===========================
    // Min, Max and average Chart
    //===========================

    chart2 () {

        var valuesNumber = this.toNumber(this.values);

        var markMax = this.max(valuesNumber) ;
        var markMin = this.min(valuesNumber);
        var markAvr = this.moyenne(valuesNumber);

        var marks = [markMin, markAvr, markMax];
        
        var myChart2 = echarts.init(document.getElementById('chart2'));

        var option2 = {
            toolbox: {
                feature: {
                    restore: {},
                    saveAsImage: {}
                }
            },
            series: [
                {
                    name: 'Notes',
                    type: 'gauge',
                    max: 10,
                    data: [{value: markMin, name: 'Mini : ' + markMin}]
                }
            ]
        };

        var myChart3 = echarts.init(document.getElementById('chart3'));

        var option3 = {
            toolbox: {
                feature: {
                    restore: {},
                    saveAsImage: {}
                }
            },
            series: [
                {
                    name: 'Notes',
                    type: 'gauge',
                    max: 10,
                    data: [{value: markAvr, name: 'Moyenne : ' + markAvr}]
                }
            ]
        };

        var myChart4 = echarts.init(document.getElementById('chart4'));

        var option4 = {
            toolbox: {
                feature: {
                    restore: {},
                    saveAsImage: {}
                }
            },
            series: [
                {
                    name: 'Notes',
                    type: 'gauge',
                    max: 10,
                    data: [{value: markMax, name: 'Maxi : ' + markMax}]
                }
            ]
        };

        // use configuration item and data specified to show chart
        myChart2.setOption(option2);
        myChart3.setOption(option3);
        myChart4.setOption(option4);
    }

    //===========================
    // Min, Max and average Chart
    //===========================

    chart3 () {        
        
        var myChart3 = echarts.init(document.getElementById('chart5'));
        
        var option3 = {

            title: {
                text: 'Combien de chaques notes'
            },
            tooltip: {},
            legend: {
                data:['Notes']
            },
            xAxis: {
                data: [0,1,2,3,4,5,6,7,8,9,10]
            },
            yAxis: {},
            series: [{
                name: 'Notes',
                type: 'bar',
                data: this.numOfMarks(this.values)
            }]
        };

        
        myChart3.setOption(option3);
    }
}