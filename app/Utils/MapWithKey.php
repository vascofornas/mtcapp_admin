<?php

namespace App\Utils;

use Zofe\Rapyd\DataForm\Field\Map;

use Collective\Html\FormFacade as Form;

class MapWithKey extends Map {

    protected $apiKey = '';
    public $type = "map-with-key";

    protected $dragLegend = 'Arrástrame';

    protected $mapWidth = 500;

    protected $mapHeight = 500;

    public function setMapWidth($width){
        $this->mapWidth = $width;
        return $this;
    }

    public function setMapHeight($height){
        $this->mapHeight = $height;
        return $this;
    }

    public function setKey($key){
        $this->apiKey = $key;
        return $this;
    }

    public function build()
    {
        $output = "";
        $this->attributes["class"] = "form-control";
        if (parent::build() === false)
            return;

        switch ($this->status) {
            case "disabled":
            case "show":

                if ($this->type == 'hidden' || $this->value == "") {
                    $output = "";
                } elseif ((!isset($this->value))) {
                    $output = $this->layout['null_label'];
                } else {
                    $output = "<img border=\"0\"
                        src=\"//maps.googleapis.com/maps/api/staticmap?center={$this->value['lat']},{$this->value['lon']}&zoom={$this->zoom}&size={$this->mapWidth}x{$this->mapHeight}\">";

                }
                $output = "<div class='help-block'>" . $output . "</div>";
                break;

            case "create":
            case "modify":
                \Rapyd::script("
                    function initialize()
                    {
                        var latitude = document.getElementById('{$this->lat}');
                        var longitude = document.getElementById('{$this->lon}');
                        var zoom = {$this->zoom};
                
                        var LatLng = new google.maps.LatLng(latitude.value, longitude.value);
                
                        var mapOptions = {
                            zoom: zoom,
                            center: LatLng,
                            panControl: false,
                            zoomControl: true,
                            scaleControl: true,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        }
                
                        var map = new google.maps.Map(document.getElementById('map_{$this->name}'),mapOptions);
                        var marker = new google.maps.Marker({
                            position: LatLng,
                            map: map,
                            title: '{$this->dragLegend}',
                            draggable: true
                        });
        
                        var update_hidden_fields = function () {
                            latitude.value = marker.getPosition().lat();
                            longitude.value = marker.getPosition().lng();
                        }
                        google.maps.event.addListener(marker, 'dragend', update_hidden_fields);
        
                        $(document.getElementById('map_{$this->name}')).data('map', map);
                        $(document.getElementById('map_{$this->name}')).data('marker', marker);
                        $(document.getElementById('map_{$this->name}')).data('update_hidden_fields', update_hidden_fields);
                        
                    }
                ");
                $output  = Form::hidden($this->lat, $this->value['lat'], ['id'=>$this->lat]);
                $output .= Form::hidden($this->lon, $this->value['lon'], ['id'=>$this->lon]);
                $output .= '<div id="map_'.$this->name.'" style="width:'.$this->mapWidth.'px; height:'.$this->mapHeight.'px"></div>';
                $output .= '<script src="https://maps.googleapis.com/maps/api/js?key='.$this->apiKey.'&amp;callback=initialize"></script>';

                break;

            case "hidden":
                $output = '';//Form::hidden($this->db_name, $this->value);
                break;

            default:;
        }
        $this->output = "\n" . $output . "\n" . $this->extra_output . "\n";
    }

}