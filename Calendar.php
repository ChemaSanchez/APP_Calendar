<?php
class Calendar {

    private $active_year, $active_month, $active_day;
    private $events = [];

    public function __construct($date = null) {
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
    }

    public function add_event($txt, $date, $days = 1, $color = '') {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color];
    }

    public function start_calendar(){
        $first_day = date('l', strtotime(date('Y-m-1')));

        $add_days = 0;

        switch ($first_day){
            case 'Monday':
                break;
            case 'Tuesday':
                $add_days = 1;
                break;
            case 'Wednesday':
                $add_days = 2;
                break;
            case 'Thursday':
                $add_days = 3;
                break;
            case 'Friday':
                $add_days = 4;
                break;
            case 'Saturday':
                $add_days = 5;
                break;
            case 'Sundçay':
                $add_days = 6;
                break;
        }
        $last_day = date("t", strtotime('-1 months'))-$add_days;
        $html ='';

        for ($i = 1; $i <= $add_days; $i++){
            $day = $last_day+$i;
            $html .= '
                <div class="day_num ignore">
                    ' . $day . '
                </div>
            ';
        }
        return $html;

    }

    public function __toString() {
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
        $days = [0 => 'Lunes', 1 => 'Martes', 2 => 'Miercoles', 3 => 'Jueves', 4 => 'Viernes', 5 => 'Sabado', 6 => 'Domingo'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
        $html = '<div class="calendar">';
        $html .= '<div class="header">';

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $html .= '<div class="month-year">';
        $html .= $meses[date('n')-1] . ' '. date('Y');
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="days">';
        foreach ($days as $day) {
            $html .= '
                <div class="day_name">
                    ' . $day . '
                </div>
            ';
        }
        $html .= $this->start_calendar();
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month-$i+1) . '
                </div>
            ';
        }
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = '';
            if ($i == $this->active_day) {
                $selected = ' selected';
            }
            $href = "onclick=location.href='./add_event.php?day=$i'";
            $html .= '<div id="test" style="cursor: pointer;" '.$href.' class="day_num' . $selected . '">';
            $html .= "<span><a href='./add_event.php?day=$i'>" . $i . "</a></span>";
            foreach ($this->events as $event) {
                for ($d = 0; $d <= ($event[2]-1); $d++) {
                    if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($event[1]))) {
                        $html .= '<div class="event' . $event[3] . '">';
                        $html .= $event[0];
                        $html .= '</div>';
                    }
                }
            }
            $html .= '</div>';
        }
        for ($i = 1; $i <= (42-$num_days-max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}
?>