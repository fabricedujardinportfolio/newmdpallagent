function datnow() {		
var now = new Date();
var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);

var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
$("#dayNow").val(today);
// console.log(today);
}
// autocomplet : this function will be executed every time we change the text
function autocomplet() {
	var keyword = $('#name').val();
	$.ajax({
		url: 'classes/ajax_refresh.php',
		type: 'POST',
		data: {keyword:keyword},	
		success:function(data){			
			$('#name_list').show();
			$('#name_list').html(data);
		}
	});
}
// function autocompletfirst_name() {
// 	var keywordfn = $('.first_name').val();
// 	$.ajax({
// 		url: 'classes/ajax_refreshfn.php',
// 		type: 'POST',
// 		data: {keywordfn:keywordfn},
// 		success:function(data){
// 			if (data==true) {				
// 			$('.first_name_list').show();
// 			$('.first_name_list').html(data);
// 			}else{
// 				alert ("aucun nom");
// 			}
// 		}
// 	});
// }
// $("#btn1").click(function(){
//   });

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	$('#name').val(item);
	// hide proposition list
	$('#name_list').hide();
	// change input value
	$('#first_name').val(item);
	// hide proposition list
	$('#first_name_list').hide();	
	$('.showSubmit').show(item);
	// hide proposition list
	console.log(item);
	if (item == "") {
		alert('Aucune valeurs');
		
	}
}
function set_name(item) {	
	// change input value
	$('#nameUser').val(item);
	// hide proposition list
	$('#nameUserListe').hide();	
}
function set_poles(item) {	
	$('#pole_id').val(item);	
	$('#nameUserListe').hide();	
}
  
function update(dataid,poleService,name,firstName,fonction,poles_services_id,role_ressource) {		
	// id du post
	console.log(dataid); 
	console.log(poleService); 
	console.log(name); 	
	console.log(firstName); 
	console.log(fonction); 
	console.log(poles_services_id); 
	console.log(role_ressource); 

	// $(".active-"+dataid).hide();	
$("#button-absence-"+dataid).hide();
$("#button-active"+dataid).hide();
$("#button-absence-"+dataid).hide();
$("#button-valider-absence-"+dataid).show();
	// let datamotifendprint = datamotifend;
	// echo (datamotifendprint);
	if (typeof dataid === "undefined") {
		console.log("id undefined"); 
	}
// *****Fonction pour choix des motifs****
$(".name_pole_service_reel-"+dataid).html(`
<select class="form-select" id="inputGroupSelect01" name="poles_services_id" type="text"  placeholder='`+poleService+`' 
onblur="(this.type='text')">		
<option value="`+poles_services_id+`">Votre anciene valeur : `+poleService+`</option>                
<option  value="1">COMMUNICATION / DOCUMENTATION​</option>
<option  value="2">DIRECTION</option>
<option  value="3">FINANCE ET RESSOURCE HUMAINE​</option>
<option  value="4">MÉTIERS DE LA MER​​</option>
<option  value="5">SPOT​</option>
<option  value="6">MAINTENANCE AUTOMOBILE / ENGINS​</option>
<option  value="7">INFORMATION ORIENTATION​</option>
<option  value="8">NUMÉRO VERT​</option>
<option  value="9">INDUSTRIE​</option>
<option  value="10">HÔTELLERIE RESTAURATION​</option>
<option  value="11">MOYENS GÉNÉRAUX​</option>
<option  value="12">COORDINATION ET PÉRI-FORMATION BOURAIL​</option>
<option  value="13">TRANSPORT LOGISTIQUE​</option>
</select>` );

$(".name-"+dataid).html(`<input  placeholder='`+name+`' type="text"  onfocus="(this.type='text')" onblur="(this.type='text')"
 value="`+name+`" id="dayNow" class="form-control" name="name" 
>`);
	// date_end
$(".first_name-"+dataid).html(`<input placeholder='`+firstName+`' type="text" value="`+firstName+`"  onfocus="(this.type='text')" onblur="(this.type='text')"
class="form-control" name="firstName"
>`);

$(".function-"+dataid).html(`<input placeholder='`+fonction+`' type="text" value="`+fonction+`"  onfocus="(this.type='text')" onblur="(this.type='text')"
class="form-control" name="function" 
>`);

$(".role_ressource-"+dataid).html(`
<select class="form-select" id="inputGroupSelect01" name="role_ressource" type="text"  placeholder='`+role_ressource+`' 
onblur="(this.type='text')">		
<option value="`+role_ressource+`">Votre anciene valeur : `+role_ressource+`</option>                
<option  value="0">USER​</option>
<option  value="1">Secrétaire</option>
<option  value="2">ADMIN​</option>
</select>` );

}