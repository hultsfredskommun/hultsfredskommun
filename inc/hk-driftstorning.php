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
                        check_date.setDate(check_date.getDate() - 7);
                        close_date = new Date(window.localStorage.getItem(driftstorning.md5));
                        if (close_date > check_date) { // don't show if less than 7 days old
                            return;
                        }
                    }
                    var driftstorningHTML = '<div class=\"driftstorning\" data-id=\"' + driftstorning.md5 + '\">';
                    driftstorningHTML += '<a class=\"close\">x</a>';
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