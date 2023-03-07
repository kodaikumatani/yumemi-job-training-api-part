import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Paper, Table, TableCell, TableRow} from '@mui/material';
import Title from './Title';
import TableMenu from './TableMenu';
import SalesTable from './SalesTable';

const SalesStatus = (props) => {
    const { date } = props;
    const [store, setStore] = useState([])
    const [select, setSelect] = useState(0)

    useEffect(() => {
        axios.get(`/api/${date}/stores`)
            .then(response => setStore(response.data.summary))
            .catch(error => console.log(error))
    }, [date]);

    return (
        <Paper
            sx={{
                p: 2,
                pt: 1,
                display: 'flex',
                flexDirection: 'column',
                height: '280px',
            }}
        >
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
        </Paper>
    );
}
export default SalesStatus;
