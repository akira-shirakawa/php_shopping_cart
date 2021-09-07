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
    if(confirm('本当に消去しますか？')){
        id= $(this).attr('class');
        id = parseInt(id);
        $('.input-js-delete-target').val(id);
        $('.form-js-delete-target').submit();
    }
   
})