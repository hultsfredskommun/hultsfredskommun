<?php

class DriftStorning {
    private $list = [];
    private $id = 0;
    function __construct() {

        if (have_rows('driftstorning', 'option')) {
            while (have_rows('driftstorning', 'option')) {
                the_row();

                if (get_sub_field('hide')) 
                    continue;
                $this->id = 'driftstorning-' . rand(1000, 9999);
                $row_layout = get_row_layout();
                $link = '';
                $target = '';
                switch (get_sub_field('link_type')) {
                    case 'external':
                        $link = get_sub_field('external_link');
                        $target = "target='_blank'";
                        break;
                    case 'file':
                        $value = get_sub_field('file');
                        if (!empty($value)) {
                            $description = $value["description"];
                            $link = $value["url"];
                            $target = "target='_blank'";
                        }
                    break;
                    case 'post':
                        $post_id = get_sub_field('post');
                        $link = ($post_id) ? get_permalink($post_id) : '';
                        break;
                    default:
                            break;
                }
                $this->list[] = [
                    'md5' => md5(get_sub_field('title')),
                    'title' => get_sub_field('title'),
                    'link' => $link,
                    'category' => get_sub_field('category'),
                    'target' => $target,
                    // 'date' => get_sub_field('date'),
                    // 'date_done' => get_sub_field('date_done'),
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
        //category: '<svg aria-hidden=\"true\" width=\"24\" height=\"24\"><path xmlns=\"http://www.w3.org/2000/svg\" d=\"M13.5,17.8c0,0.8-0.6,1.5-1.4,1.5h0c-0.8,0-1.4-0.6-1.4-1.5c0-0.9,0.6-1.5,1.5-1.5 C12.9,16.3,13.4,16.9,13.5,17.8z M11.1,15.5h1.8l0.4-7.3h-2.6L11.1,15.5z M23.3,21.7c-0.3,0.4-0.7,0.7-1.3,0.7H2 c-0.5,0-1-0.3-1.3-0.7c-0.3-0.5-0.3-1,0-1.5L10.8,2.3C11,1.9,11.5,1.6,12,1.6h0c0.5,0,1,0.3,1.3,0.8l10,17.9 C23.6,20.7,23.6,21.2,23.3,21.7z M22,20.9L12,3.1L2,20.9H22z\"/></svg>',
        
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
                    var icons = {
                        category: '<svg aria-hidden=\"true\" width=\"24\" height=\"24\"><path xmlns=\"http://www.w3.org/2000/svg\" d=\"M12 0C5.371 0 0 5.371 0 12s5.371 12 12 12 12-5.371 12-12S18.629 0 12 0zm0 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zm-1 4v8h2V6zm0 10v2h2v-2z\"/></svg>',
                        close: '<svg xmlns=\"https://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"none\" class=\"times\"><path d=\"M15.176 0L16 .825.825 15.999 0 15.175 15.176 0z\" fill=\"#333\"></path><path d=\"M.825 0L16 15.175l-.825.825L0 .825.825 0z\" fill=\"#333\"></path></svg>'
                    };
                    var driftstorningHTML = '<div class=\"driftstorning ' + driftstorning.category + '\" data-id=\"' + driftstorning.md5 + '\">';
                    var title = (driftstorning.title) ? '<span class=\"title\">' + driftstorning.title + '</span>' : '';
                    var description = (driftstorning.description) ? '<span class=\"description\">' + driftstorning.description + '</span>' : '';
                    var link = (driftstorning.link) ? 'href=\"' + driftstorning.link + '\"' : '';
                    var link_tag = (driftstorning.link) ? 'a' : 'span';
                    driftstorningHTML += '<span class=\"category ' + driftstorning.category + '\">' + icons['category'] + '</span>';
                    driftstorningHTML += '<' + link_tag + ' ' + driftstorning.target + ' ' + link + '>' + title + description + '</' + link_tag + '>';
                    driftstorningHTML += '<a class=\"close\">' + icons['close'] + '</a>';

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