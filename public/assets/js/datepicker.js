$(function() {
  'use strict';

  if($('#datePickerExample').length) {
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('#datePickerExample').datepicker({
      format: "mm/dd/yyyy",
      todayHighlight: true,
      autoclose: true
    });
    $('#datePickerExample').datepicker('setDate', today);
  }
  

  if($('.dobdatePicker').length) {
    var maxBirthdayDate = new Date();
        maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 18,maxBirthdayDate.getMonth(),maxBirthdayDate.getDate());
    $('.dobdatePicker').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "dd-mm-yy",
      todayHighlight: true,
      autoclose: true,
      maxDate: maxBirthdayDate,
      yearRange: '1950:'+maxBirthdayDate.getFullYear(),
       
    });
  }
  if($('#joindatePicker').length) {
    var date = new Date();
    var currentDate = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('#joindatePicker').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "dd-mm-yy",
      todayHighlight: true,
      autoclose: true,
      endDate: "currentDate",
      maxDate: currentDate,    
      yearRange: "-52:+00",   
    });

  }

  if($('#meetingdatePicker').length) {
    var date = new Date();
    var currentDate = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('#meetingdatePicker').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "dd-mm-yy",
      todayHighlight: true,
      autoclose: true,
      minDate: new Date(date.getFullYear(), date.getMonth(), date.getDate()),
      endDate: "currentDate",    
      yearRange: "-52:+00",   
    });

  }
});