$('.js-add-target').click(function(){
    id = $(this).attr('class');
    id = parseInt(id);
    console.log(id);
    $("#item_id").val(id);
    $('#item').submit();

}),
$('.js-edit-target').click(function(){
    $('#edit-modal').toggleClass('is-active');
    
    id= $(this).attr('class');
    number = $(this).parent().prev().prev().prev().text();
    id = parseInt(id);
    $('.js-sale-edit-target').val(number);
    $('.js-item_id').val(id);

}),
$('.modal-background').click(function(){
    console.log('hoge');
    $('.modal').removeClass('is-active');
}),
$('#js-edit-amount').submit(function(){
    if($('.js-sale-edit-target').val()<=0){
        return false;
    }else{
        $(this).submit();
    }
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
}),

console.log($("tr").length);
if($('tr').length > 2){
    $('.js-cart-target-button').removeClass('is-hidden');
}
