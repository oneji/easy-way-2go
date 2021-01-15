$(function() {
    // $('#routesCalendar').datepicker({});
    
    // function initCalendar() {
    //     var container = $(".search-calendar");
    //     var calendar = container.find(".bs-datepicker");
    //     if (!container.length || !calendar.length)
    //         return;
    //     var inputs = container.find('.range-input');
    
    //     calendar.datepicker({
    //         format: "dd-mm-yyyy",
    //         startView: 0,
    //         maxViewMode: 2,
    //         language: "ru",
    //         weekStart: 1,
    //         inputs: calendar.find('.range-start, .range-end'),
    //         templates: {
    //             leftArrow: "<i class=\"fa fa-angle-left\"></i>",
    //             rightArrow: "<i class=\"fa fa-angle-right\"></i>"
    //         }
    //     });
      
    //     var start = calendar.find('.range-start'),
    //         end = calendar.find('.range-end');

    //     end.hide();
    //     start.on('changeDate', function (e) {
    //         if (typeof e.dates !== 'undefined' && e.dates.length && start.is(':visible')) {
    //             end.show();
    //             start.hide();
    //             if (inputs && inputs.length) {
    //                 $(inputs[0]).val(e.format());
    //             }
    //         }
    //     });
    
    //     end.on('changeDate', function (e) {
    //         if (typeof e.dates !== 'undefined' && e.dates.length && end.is(':visible')) {
    //             start.show();
    //             end.hide();
    //             if (inputs && inputs.length && inputs.length > 1) {
    //                 $(inputs[1]).val(e.format());
    //             }
    //         }
    //     });
    // }

    // initCalendar();
    
    // $('.info-btn').on('click', function(e) {
    //     e.preventDefault();

    //     let infoBtn = $(this);
    //     let infoModal = $('#routeInfoModal');
    //     let id = infoBtn.data('id');
    //     let loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';
    //     let infoIcon = '<i class="bx bx-info-circle"></i>';

    //     infoBtn.html(loadingIcon);

    //     $.ajax({
    //         url: '/api/routes/getById/' + id,
    //         success: function(response) {
    //             console.log(response)
    //             let { data } = response;

    //             let routeForwardTimeline = infoModal.find('#routeForwardTimeline');
    //             let routeBackTimeline = infoModal.find('#routeBackTimeline');
    //             let routeCalendar = infoModal.find('#calendar');
    //             routeForwardTimeline.html('');
    //             routeBackTimeline.html('');

    //             data.route_addresses.map(address => {
    //                 if(address.type === 'forward') {
    //                     routeForwardTimeline.append(`
    //                         <li class="event-list pb-3">
    //                             <div class="event-timeline-dot">
    //                                 <i class="bx bx-right-arrow-circle"></i>
    //                             </div>
    //                             <div class="media">
    //                                 <div class="mr-3">
    //                                     <i class="bx bx-map-alt h4 text-primary"></i>
    //                                 </div>
    //                                 <div class="media-body">
    //                                     <div>
    //                                         <h5 class="font-size-15"><a href="#" class="text-dark">${address.address}</a></h5>
    //                                         <span class="text-primary">${address.departure_time}</span>
    //                                     </div>
    //                                 </div>
    //                             </div>
    //                         </li>
    //                     `);
    //                 } else if(address.type === 'back') {
    //                     routeBackTimeline.append(`
    //                         <li class="event-list pb-3">
    //                             <div class="event-timeline-dot">
    //                                 <i class="bx bx-right-arrow-circle"></i>
    //                             </div>
    //                             <div class="media">
    //                                 <div class="mr-3">
    //                                     <i class="bx bx-map-alt h4 text-primary"></i>
    //                                 </div>
    //                                 <div class="media-body">
    //                                     <div>
    //                                         <h5 class="font-size-15"><a href="#" class="text-dark">${address.address}</a></h5>
    //                                         <span class="text-primary">${address.departure_time}</span>
    //                                     </div>
    //                                 </div>
    //                             </div>
    //                         </li>
    //                     `);
    //                 }
    //             });

    //             data.route_repeats.map(date => {
    //                 // routeCalendar.find('#routesCalendar').datepicker('setDates', [date.from])
    //             });

    //             infoBtn.html(infoIcon);
    //             infoModal.modal(true);
    //         },
    //         error: function(err) {
    //             console.log(err)
    //         }
    //     });
    // });
});