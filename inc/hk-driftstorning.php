<?php

class DriftStorning {
    private $list = [];
    private $id = 0;
    function __construct() {

        if (get_field('driftstorning', 'option')) {
            while (has_sub_field('driftstorning', 'option')) {

                if (get_sub_field('hide')) 
                    continue;
                $this->id = 'driftstorning-' . rand(1000, 9999);
                $row_layout = get_row_layout();
                $this->list[] = [
                    'md5' => md5(get_sub_field('title')),
                    'title' => get_sub_field('title'),
                    'date' => get_sub_field('date'),
                    'date_done' => get_sub_field('date_done'),
                    'description' => get_sub_field('description')
                ];
            }
            
        }

    }
    public function getActive() {
        return count($this->list) > 0;
    }

    public function getID() {
        return $this->id;
    }
    public function getHTML() {
        return "<script>
        var driftstorningar = " . json_encode($this->list) . ";
        (function($) {

            $(document).ready( () => {
                driftstorningar.forEach(function(driftstorning) {
                    if (window.localStorage.getItem(driftstorning.md5) != '') {
                        check_date = new Date();
                        check_date.setDate(check_date.getDate() - 7); // 7 days ago
                        close_date = new Date(window.localStorage.getItem(driftstorning.md5));
                        if (close_date > check_date) { // don't show if less than 7 days old
                            return;
                        }
                    }
                    var driftstorningHTML = '<div class=\"driftstorning\" data-id=\"' + driftstorning.md5 + '\">';
                    driftstorningHTML += '<a class=\"close\"><svg xmlns=\"https://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"none\" class=\"times\"><path d=\"M15.176 0L16 .825.825 15.999 0 15.175 15.176 0z\" fill=\"#fff\"></path><path d=\"M.825 0L16 15.175l-.825.825L0 .825.825 0z\" fill=\"#fff\"></path></svg></a>';
                    driftstorningHTML += '<h2>' + driftstorning.title + '</h2>';
                    driftstorningHTML += driftstorning.description;
                    driftstorningHTML += '<p class=\"dates\">';
                    if (driftstorning.date) 
                        driftstorningHTML += '<date>Datum: ' + driftstorning.date + '</date>';
                    if (driftstorning.date_done) 
                        driftstorningHTML += '<date>Beräknat klart: ' + driftstorning.date_done + '</date>';
                    driftstorningHTML += '</p>';
                    driftstorningHTML += '</div>';
                    $('#" . $this->id. "').append(driftstorningHTML);
                });
                $('.driftstorning .close').click(function(e) {
                    e.preventDefault();
                    var id = $(this).parent().attr('data-id');
                    window.localStorage.setItem(id, Date());
                    $(this).parent().hide();
                });
            });
        })(jQuery);
        </script>";
    }
}