class Calendar {

    constructor(apiDatas) {
        this.datas = apiDatas;

        this.zoneABC(this.datas);
        this.zoneA(this.datas);
        this.zoneB(this.datas);
        this.zoneC(this.datas);

        this.viewCalendar();
    }

    zoneABC(datas) {
        this.zoneABC = [];

        this.zoneABC["Start-Teacher"] = datas[11].fields.start_date;

        this.zoneABC["Start-Student"] = datas[12].fields.start_date;

        this.zoneABC["Start-Toussaint"] = datas[4].fields.start_date;
        this.zoneABC["End-Toussaint"] = datas[4].fields.end_date;

        this.zoneABC["Start-Noel"] = datas[5].fields.start_date;
        this.zoneABC["End-Noel"] = datas[5].fields.end_date;

        this.zoneABC["Start-Ete"] = datas[14].fields.start_date;
    }

    zoneA(datas) {
        this.zoneA = [];
        this.zoneA["Start-Hiver"] = datas[20].fields.start_date;
        this.zoneA["End-Hiver"] = datas[20].fields.end_date;

        this.zoneA["Start-Spring"] = datas[13].fields.start_date;
        this.zoneA["End-Spring"] = datas[13].fields.end_date;
    }

    zoneB(datas) {
        this.zoneB = [];
        this.zoneB["Start-Hiver"] = datas[2].fields.start_date;
        this.zoneB["End-Hiver"] = datas[2].fields.end_date;

        this.zoneB["Start-Spring"] = datas[16].fields.start_date;
        this.zoneB["End-Spring"] = datas[16].fields.start_date;
    }

    zoneC(datas) {
        this.zoneC = [];
        this.zoneC["Start-Hiver"] = datas[6].fields.start_date;
        this.zoneC["End-Hiver"] = datas[6].fields.end_date;

        this.zoneC["Start-Spring"] = datas[21].fields.start_date;
        this.zoneC["End-Spring"] = datas[21].fields.end_date;
    }

    viewCalendar() {
        $('#teacher_start').text(this.zoneABC["Start-Teacher"]);
        $('#student_start').text(this.zoneABC["Start-Student"]);

        $('#toussaint_start').text(this.zoneABC["Start-Toussaint"]);
        $('#toussaint_end').text(this.zoneABC["End-Toussaint"]);

        $('#noel_start').text(this.zoneABC["Start-Noel"]);
        $('#noel_end').text(this.zoneABC["End-Noel"]);

        $('#ete_start').text(this.zoneABC["Start-Ete"]);

        $('#A_hiver_start').text(this.zoneA["Start-Hiver"]);
        $('#A_hiver_end').text(this.zoneA["End-Hiver"]);

        $('#A_spring_start').text(this.zoneA["Start-Spring"]);
        $('#A_spring_end').text(this.zoneA["End-Spring"]);

        $('#B_hiver_start').text(this.zoneB["Start-Hiver"]);
        $('#B_hiver_end').text(this.zoneB["End-Hiver"]);

        $('#B_spring_start').text(this.zoneB["Start-Spring"]);
        $('#B_spring_end').text(this.zoneB["End-Spring"]);

        $('#C_hiver_start').text(this.zoneC["Start-Hiver"]);
        $('#C_hiver_end').text(this.zoneC["End-Hiver"]);

        $('#C_spring_start').text(this.zoneC["Start-Spring"]);
        $('#C_spring_end').text(this.zoneC["End-Spring"]);
    }

}