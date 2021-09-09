$('#js-text1').keyup(function(){
    text1 = $(this).val();
    $('#js-text1-target').text(text1);
}),
$('#js-text2').keyup(function(){
    text2 = $(this).val();
    $('#js-text2-target').text(text2);
}),
$('#js-number1').change(function(){
    number1 = $(this).val();
    console.log(number1);
    $('#js-number1-target').text(number1);
}),
$('#file').change(function(e){

    e.preventDefault;
    e.stopPropagation;
    file = e.target.files[0];
    console.log(file.size);
    if(file.size>=1000000 || !file.type.match(/image\/*/)){
        alert('1メガバイト未満の画像ファイルを提出してください');
        return false;
    }
   
    reader = new FileReader();
    console.log(reader);
      reader.onload=(function(e){
        $('#js-image-target').attr('src',e.target.result);
    });
    reader.readAsDataURL(file);
      
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
    id = id.replace(/[^0-9]/g, '');
    console.log(id);
    $('.input-js-delete-target').val(id);
   $('.form-js-delete-target').submit();
    
}),
$('#no').click(function(){
    $('#delete-modal').removeClass('is-active');
}),
$('.modal-background').click(function(){
    console.log('hoge');
    $('.modal').removeClass('is-active');
})