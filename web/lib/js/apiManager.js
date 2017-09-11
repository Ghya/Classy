// Gestion de reception des données de l'API

var loadApi = {

    loadCalendarData: function () {
        ajaxGet("http://localhost/jsonClassy/fr-en-calendrier-scolaire.json", function (resp) {
            var calendarDatas = JSON.parse(resp);
            var calendar = new Calendar(calendarDatas);
        })
    },

    loadChartsData: function () {
        ajaxGet("http://localhost/jsonClassy/fr-en-calendrier-scolaire.json", function (resp) {
            var calendarDatas = JSON.parse(resp);
            var calendar = new Calendar(calendarDatas);
        })
    }
}