$('.modal-background').click(function(){
    console.log('hoge');
    $('.modal').removeClass('is-active');

}),
$('.js-delete-target').click(function(){

    id= $(this).attr('class');
    id = parseInt(id);
    strId = String(id);
    $('#delete-modal').addClass(strId);
    $('#delete-modal').addClass('is-active'); 
}),
$('#yes').click(function(){
    id = $('#delete-modal').attr('class');
    id = id.match(/[0-9]+(?=[^0-9]+$)/g)[0];
    console.log(id);
    $('.input-js-delete-target').val(id);
   $('.form-js-delete-target').submit();
    
}),
$('#no').click(function(){
    $('#delete-modal').removeClass('is-active');
}),
$('.js-cart-target-button').click(function(){
    $('#cart-modal').addClass('is-active');
})
console.log($('tr').length);
if($('tr').length == 1){
    $('table').text('データはありません。');
}