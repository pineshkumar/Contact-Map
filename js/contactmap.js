(function ($, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.contactmap = {

    attach: function (context, settings) {

      $(document).ready(function () {
        var maap;
        var myMarker;
        var myLatlng;
        var mapOptions;
        var mapPhoneNumber = drupalSettings.mapPhoneNumber;
        var mapAddressContact = drupalSettings.mapAddressContact;
        // Map Latitude and Longitude.
        var mapLatitude = drupalSettings.mapLatitude;
        var mapLongitude = drupalSettings.mapLongitude;

        if ($('body').length && !($('#cms_contactmap').length)) {
          var mapGooglekey = drupalSettings.mapGooglekey;

          if (mapGooglekey) {
            $('body').append('<script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=' + mapGooglekey + '"></script>');
          }
          else {
            $('body').append('<script src="//maps.googleapis.com/maps/api/js"></script>');
          }
          $('body').append('<section class="stage" id="cms_contactmap"><figure class="ball"></figure></section><div id="dialog" style="display: none"> <div id="dvMap" style="height: 280px; width: 330px;"> </div></div>');
        }

        $('#cms_contactmap').click(function () {
          $('#dialog').dialog({
            modal: true,
            title: 'Address : ' + mapAddressContact + '<br> Phone : ' + mapPhoneNumber,
            width: 360,
            hright: 250,
            buttons: {
              Close: function () {
                $(this).dialog('close');
              }
            },
            open: function () {
              myLatlng = new google.maps.LatLng(mapLatitude, mapLongitude);
              mapOptions = ({
                center: myLatlng,
                zoom: 5,
                mapTypeId: google.maps.MapTypeId.ROADMAP
              });
              maap = new google.maps.Map($('#dvMap')[0], mapOptions);
              myMarker = new google.maps.Marker({
                position: myLatlng
              });
              myMarker.setMap(maap);
            }
          });

        });

        $('#cms_contactmap').draggable({
          containment: 'body',
          scroll: false
        });

      });
    }
  };
})(jQuery, Drupal, drupalSettings);
