

$('input#name-submit').on('click', function(){
	var Id = $('input#name').val();
	if($.trim(Id) != ''){
		$.post('test1.php', {Id: Id}, function(data){
			$('div#name-data').text(data);
		});
	}
});

$('#name-submit').on('click', function(){
	alert("HAHA");
	console.log("HAHA");
	window.location.assign("test1.php");
});

// $('#name-submit').click(function (e) {
//     e.preventDefault();
//     alert('1st click event');
// });

// $('#name-submit').click(function (e) {
//     e.preventDefault();
//     alert('2nd click event')
// });



// function loadQueryResults() {
//     $('input#name-submit').load('../ajax/ajax.php');
// }