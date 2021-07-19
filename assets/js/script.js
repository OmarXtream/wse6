
	var notifyCount;
 	var xmlhttp;
	var token=document.getElementsByTagName('meta')["token"].content;
	var ajax_location = 'ajax/';

function handleResponse(response){
	response.then(function(response){
		if(typeof response.updatetoken != 'undefined'){
			document.getElementsByTagName('meta')["token"].content = response.updatetoken;
		}
	});
	return response;
}
function sendData(url = ``, data = '', method = 'POST',token = true) {
	if(token){
		data = data+'&token='+document.getElementsByName('token')[0].getAttribute('content');
	}
    if(method == 'POST'){
    return fetch(ajax_location + url, {
        method: method, // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, cors, *same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, same-origin, *omit
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        redirect: "follow", // manual, *follow, error
        body: data // body data type must match "Content-Type" header
    })
    .then(response => handleResponse(response.json())); // parses response to JSON
    } else if(method == 'GET'){
		
        return fetch(ajax_location + url + '?' + data).then(response => handleResponse(response.json()));
    }
	
}
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	notification();
			function _orderCreate() {
			var idqasm = document.getElementById("selectQasm").value;
			var describe = document.getElementById("describe").value;
			var nameCustomer = document.getElementById("name").innerText;
			describe = describe.replace(/\r?\n/g, ' ');
			
			if(!isNaN(idqasm)){
			
				if(idqasm != "" && idqasm != null && idqasm != undefined && describe != "" && describe != null && describe != undefined){
					if(describe.length > 256 ){
						alertify.logPosition("top right");
						alertify.error("يجب إن لايتعدى الوصف عن 256 حرف.");
						
						throw new Error('تعدى الحروف المسموح بها.')
					}	
					sendData("mediations.php", "qasm="+idqasm+"&describe="+describe)
					.then(function(response){
						if(response.error){
							location.reload();
						} else {
							swal({
							  title: response.t,
							  text: response.m,
							  type: response.s,
							  confirmButtonText: response.b
							});
							if(response.done == true){
								document.getElementById("selectQasm").selectedIndex = 0;
								document.getElementById("describe").value = '';
								document.getElementById("describe").placeholder = 'مثأل : إسم البرنامج ،،الخ..';
								setTimeout(function(){ location.reload(); }, 3000);
							}
						}
					});
			}else{
				alertify.logPosition("top right");
				alertify.error(" تأكد من المدخلات سيد " + nameCustomer);
			}
					
		}else{
			location.reload();
		}
		
		}
		
		
		window.setInterval(function(){
			var card=document.getElementById("wstacard");

			var checkExists = document.body.contains(card);
				if(window.location.toString().indexOf("order") != -1 && checkExists != false){
				
					updateInfo(); 
			
				}
			
		}, 10000);				
			
			function updateInfo(){
			
			
			sendData("mediations.php", "update=1")
			.then(function(response){
				if(response.error){
					location.reload();
				} else if(response.doneUpdated){
					var replyMid=document.getElementById("repliesMid");
					var maxPrice=document.getElementById("maxPrice");
					var minPrice=document.getElementById("minPrice");
					var countWas6a=document.getElementById("countWas6a");
					if(response.dataws6a != replyMid){
						replyMid.innerHTML=response.dataws6a;
					} else if(response.maxPrice != maxPrice){
						maxPrice.innerText=response.maxPrice;
					} else if(response.minPrice != minPrice){
						minPrice.innerText=response.minPrice;
					} else if(response.count != countWas6a){
						countWas6a.innerText=response.count;
					} else {}
				}
			});
		}
		
		function _sure(question,qicon,runthis,thisarg,twoarg){
			
		swal({
			title: "هل انت متاكد؟",
			text: question,
			type: qicon,
			showCancelButton: true,
			cancelButtonColor: "#ef5350",
			confirmButtonText: "نعم",
			cancelButtonText: "لأ"
			})
			.then((rep) => {
				if (rep) {
					if(rep.dismiss !== 'overlay' && rep.dismiss !== 'esc'){
						if(rep.value == true){
							if(typeof thisarg != 'undefined' && typeof twoarg == 'undefined'){
							runthis(thisarg); // _sure("ثفثقف","info",wseet,"info",75);
							}else{
							runthis(thisarg,twoarg);
							}	
						}else{
							
						}
				}
				}
				
			});
			
			
		}
		
		function wseet(action,id){
				if(typeof id == 'undefined'){
					throw new Error("قيمة غير مححدة")
				}
				
			sendData("mediations.php", "action="+action+"&id="+id)
			.then(function(response){
				if(response.error){
					location.reload();
				}else if(response.type == "doneInfo"){
					swal({
						title: "رد الوسيط: " + response.name,
						html: response.text + "<br /> عمولتي: <i class='fa fa-money'></i> " + response.price,
						type: "info",
						confirmButtonText: "موافق"
					});	
				}else if(response.type == "doneAccept"){
					swal({
						title: "تم قبول الوسيط بنجاح",
						text: "آلان حان وقت التاكد من الوسيط!",
						type: "success",
						confirmButtonText: "موافق"
					});
					document.getElementById("wsta").innerHTML="";
					document.getElementById("wstacard").innerHTML="";
					document.getElementById("wsataboxtitle").innerHTML="التحقق من الكود";
					document.getElementById("wsatacontent").innerHTML=response.content;
				}else{
					swal({
						title: response.t,
						text: response.m,
						type: response.s,
						confirmButtonText: response.b
					});
				}
			});
		}
		

		function _cancel(action){
			sendData("mediations.php", "cancel="+action)
			.then(function(response){
				if(response.error){
						location.reload();
				} else if(response.doneClose){
					swal({
						title: "حسناً",
						text: "تم إغلاق طلبك للوساطة بنجاح",
						type: "success",
						confirmButtonText: "موافق"
					});	
					setTimeout(function(){ location.reload(); }, 3000);
				}else if(response.doneTbdel){
					swal({
						title: "حسناً",
						text: "تم تبديل الوساطة ،، جاري تحديث الصفحة..",
						type: "success",
						confirmButtonText: "موافق"
					});
					setTimeout(function(){ location.reload(); }, 3000);
				}else{
					swal({
						title: response.t,
						text: response.m,
						type: response.s,
						confirmButtonText: response.b
					});
				}
			});
		}
		

		$('#notifyListener').on('focusout', function () {
			if(notifyCount > 0){
						xmlhttp.open("GET", "ajax/notification.php?remnotify=", false);
						xmlhttp.send();
						notifyCount = 0;					
				}
		});

		function notification(){
			sendData("notification.php", "notification=",'GET')
			.then(function(response){
				if(response.error){
					location.reload();
				}else if(response.notification !== '' && response.notification !== null && response.emptynotify == false){
					document.getElementById('notifybox').style.height='300px';
					document.getElementById('allnotifications').innerHTML=response.notification;
					document.getElementById('nonotify').innerHTML='';
					document.getElementById('notifyCount').innerHTML=response.notifyCount;
				}else if(response.emptynotify == true && response.notification == null || response.emptynotify == true && response.notification == ''){
					document.getElementById('notifybox').style.height='auto';
					document.getElementById('allnotifications').innerHTML='';
					document.getElementById('nonotify').innerHTML='<h5 class="h6 text-center py-10 mb-50 mt-50 text-uppercase">لا يوجد أي تنبيهات</h5>';
					document.getElementById('notifyCount').innerHTML=response.notifyCount;
				}
				notifyCount = response.notifyCount;
			});
		}
 