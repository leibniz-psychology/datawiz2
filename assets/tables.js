import DataTable from 'datatables.net';
//import 'datatables.net-dt/css/jquery.dataTables.min.css';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';

const table = document.querySelector('.data-table');

if (table) {
	new DataTable('.data-table', {
		// options
	});
}