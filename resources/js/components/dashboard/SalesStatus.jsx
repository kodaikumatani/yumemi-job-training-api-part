import * as React from 'react';
import axios from "axios";
import Table from '@mui/material/Table';
import TableCell from '@mui/material/TableCell';
import TableRow from '@mui/material/TableRow';
import Title from './Title';
import TableMenu from "./TableMenu";
import SalesTable from "./SalesTable";

export default function SalesStatus(props) {
    const { date } = props;
    const [store, setStore] = React.useState([])
    const [select, setSelect] = React.useState(0)

    React.useEffect(() => {
        axios.get(`/api/${date}/stores`)
            .then(response => setStore(response.data.summary))
            .catch(error => console.log(error))
    }, []);

    return (
        <React.Fragment>
            <Table size="small">
                <TableRow>
                    <TableCell style={{borderBottom:"none", padding: 0}}>
                        <Title>Sales Status</Title>
                    </TableCell>
                    <TableCell align="right" style={{borderBottom:"none", padding:"none"}}>
                        <TableMenu store={store} select={select} setSelect={setSelect}/>
                    </TableCell>
                </TableRow>
            </Table>
            <SalesTable date={date} id={select} />
        </React.Fragment>
    );
}
