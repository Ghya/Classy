class Model {
    constructor () {
        this.classChecker();
        this.testChecker();
    }

    classChecker () {
        if ($('#testDate').length){
            var chartsClass = new ChartsClass(
                JSON.parse($('#testDate').text()), 
                JSON.parse($('#testAvg').text()), 
                JSON.parse($('#classAvg').text()), 
                JSON.parse($('#classDate').text()),
                JSON.parse($('#avgPlus').text()),
                JSON.parse($('#avgMinus').text())
            ); 
        }
    }

    testChecker () {
        if ($('#markStud').length){
            var testClass = new ChartsTest(
                JSON.parse($('#markStud').text()),
                JSON.parse($('#markValue').text())
            ); 
        }
    }
}