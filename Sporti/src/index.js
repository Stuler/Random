import "./custom/naja/initNaja";
import "materialize";
import "materialize-css";
import "materialize-css/sass/materialize.scss";
import "./../src/css/sass/custom.sass";


document.addEventListener('DOMContentLoaded', function () {
	var elems = document.querySelectorAll('select');
	var instances = M.FormSelect.init(elems, {
		// specify options here
	});
});