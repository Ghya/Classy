class PageController {

    // Initiate pages
    constructor(elem, nbSlide, currentSlide) {
        this.currentSlide = currentSlide;
        this.nbSlide = nbSlide;
        this.tableSlide = (elem.find(".chapter_page"));
        this.slideShow = this.tableSlide[this.currentSlide];
        this.tableSlide.hide();
        $(this.slideShow).show();

        // reception url pour chapitre courant
        this.url = document.location.href;
        this.urlChapterNbr  = this.url.substring(this.url.lastIndexOf( "/" )+1 );

        // reception des cookies
        this.page = this.getCookie("page");
        this.markChapter = this.getCookie("marker");

        if (this.page != "" && this.markChapter === this.urlChapterNbr) {
            this.toSlide(this.page);
        }
        
        this.listenEvent();
        this.setActive();
    }

    // Move slide
    moveSlide() {
        $(this.slideShow).fadeOut(600);
        this.slideShow = this.tableSlide[this.currentSlide];
        $(this.slideShow).fadeIn(600);
        this.setActive();
        
    }

    // Aller à la slide ..
    toSlide(slide) {
        this.currentSlide = slide - 1;
        this.moveSlide();
    }

    // Slide suivante
    nextSlide() {
        this.currentSlide++;
        if (this.currentSlide >= this.nbSlide) {
            this.currentSlide = 0;
        }
        this.moveSlide();
    }

    // Slide précédente
    prevSlide() {
        this.currentSlide--;
        if (this.currentSlide < 0) {
            this.currentSlide = this.nbSlide - 1;
        }
        this.moveSlide();
    }

    // Active Pagination
    setActive() {

        $(".page_activ").removeClass('page_activ');
        $("#pagination_container").find("button").eq(this.currentSlide + 1).addClass("page_activ");
        
    }

    // Lire le cookie pour la page marquée

    getCookie(name) {

     if(document.cookie.length == 0)
       return null;

     var regSepCookie = new RegExp('(; )', 'g');
     var cookies = document.cookie.split(regSepCookie);

     for(var i = 0; i < cookies.length; i++){
       var regInfo = new RegExp('=', 'g');
       var infos = cookies[i].split(regInfo);
       if(infos[0] == name){
         return unescape(infos[1]);
       }
     }
     return null;
   }

   checkMarker() {
       if (this.page == this.currentSlide + 1) {
            $('#ico_marker').css('display', 'block');
        } else {
            $('#ico_marker').css('display', 'none');  
        }
   }

    // Les Evenements
    listenEvent() {
        $("#next_page").click(function () {
            this.nextSlide();
            this.checkMarker();
            
        }.bind(this));

        $("#prev_page").click(function () {
            this.prevSlide();
            this.checkMarker();
        }.bind(this));

        $(".page_pagination").click(function (e) {

            if (this.currentSlide + 1 == e.target.textContent) {
                return false;
            } else {
                this.toSlide(e.target.textContent);
            }

            this.checkMarker();
        }.bind(this));
        
        window.addEventListener("keydown", function (e) {            
            if (e.keyCode === 37) {
                this.prevSlide();
            }
            if (e.keyCode === 39) {
                this.nextSlide();
            }

            this.checkMarker();
        }.bind(this));

        $("#page_marker").click(function () {
            document.cookie = 'page='+(this.currentSlide+1)+'; expires=Wed, 1 Jan 2070 13:47:11 UTC; path=/'
        }.bind(this));

        this.checkMarker();
    }
}
