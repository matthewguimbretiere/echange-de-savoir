window.addEventListener('load',function(){
	/*----------VERIFICATION AUTRE FORMULAIRE INITIATIVE-------*/
	var select = document.getElementById('titreInitiative');
	var titreInitiativeAutre = document.getElementById('titreInitiativeAutre');
	select.addEventListener( "change", function ( e ) {
		if(e.target.value == "autre"){
			titreInitiativeAutre.removeAttribute('hidden');
			titreInitiativeAutre.style.display="inline-block";
		} else {
			titreInitiativeAutre.setAttribute('hidden','hidden');
			titreInitiativeAutre.style.display="none";
		}
	})
	
})