import DataTable from 'datatables.net';
import 'datatables.net-dt/css/jquery.dataTables.min.css';

const table = document.querySelector('.data-table');

if (table) {
	new DataTable('.data-table', {
		// options
	});
}