(function ($) {
    "use strict";

    // MENU
    $(".navbar-collapse a").on("click", function () {
        $(".navbar-collapse").collapse("hide");
    });

    // CUSTOM LINK
    $(".smoothscroll").click(function () {
        var el = $(this).attr("href");
        var elWrapped = $(el);
        var header_height = $(".navbar").height();

        scrollToDiv(elWrapped, header_height);
        return false;

        function scrollToDiv(element, navheight) {
            var offset = element.offset();
            var offsetTop = offset.top;
            var totalScroll = offsetTop - navheight;

            $("body,html").animate(
                {
                    scrollTop: totalScroll,
                },
                300
            );
        }
    });

})(window.jQuery);

function togglePelatihan() {
    var kategori = document.getElementById('jenis_kategori').value;
    document.getElementById('pelatihan_inti_wrap').classList.add('d-none');
    document.getElementById('pelatihan_pendukung_wrap').classList.add('d-none');
    if (kategori === 'inti') {
        document.getElementById('pelatihan_inti_wrap').classList.remove('d-none');
    } else if (kategori === 'pendukung') {
        document.getElementById('pelatihan_pendukung_wrap').classList.remove('d-none');
    }
}