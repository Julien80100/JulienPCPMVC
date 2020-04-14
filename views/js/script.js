   function confirmed(url) 
   {
          console.log(url);
        
          if ( false === confirm("Voulez-vous supprimer cet élément") ) {
                
            return;
            
          } else {
            
            //var url = 'http://195.154.118.169/julien/TP/index.php?c=tache&t=deleted&id='+id;
            var Request = new XMLHttpRequest();
            
            Request.open("POST", url, false);
            
            Request.onreadystatechange = function () {
              
                if ( Request.status === 200 || Request.status === 0 ) {

                   alert("Elément supprimé !");
//                    window.location.href = 'http://195.154.118.169/julien/TP/index.php?c=tache&t=list';
                  window.location.reload(true);  

                } 
              
            }
            
            Request.send();
            
         }
        
  }

//   function displayhour()
//   {
//     var time = new Date();
//     var myTimeDiv = document.getElementById('time');
//     var secondes = time.getSeconds();
//     var minutes = time.getMinutes();
//     var heures = time.getHours();
    
//     if ( time.getHours() >= 0 && time.getHours() < 10 ) {
       
//       heures = "0"+time.getHours();
      
//     }
    
//     if ( time.getMinutes() >= 0 && time.getMinutes() < 10 ) {
       
//       minutes = "0"+time.getMinutes();
      
//     }
    
//     if ( time.getSeconds() >= 0 && time.getSeconds() < 10 ) {
       
//       secondes = "0"+time.getSeconds();
      
//     }
    
//     var newTime = heures+'h '+minutes+'m '+secondes;
   
//     myTimeDiv.innerHTML = newTime;
    
//   }
//   var timetodisplay = setInterval(displayhour, 1000);