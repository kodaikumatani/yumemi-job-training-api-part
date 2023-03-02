import * as React from 'react';
import axios from "axios";
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import { TableContainer } from "@mui/material";

function buildQueryString(id) {
    let string = "";
    if(id > 0) {
        string += `?store_id=${id}`;
    }
    return string;
}

export default function SalesTable(props) {
    const { date, id } = props
    const NWC = new Intl.NumberFormat();
    const [sales, setSales] = React.useState([]);

    React.useEffect(() => {
        axios.get(`/api/sales/daily/${date}${buildQueryString(id)}`)
            .then(response => setSales(response.data.details))
            .catch(error => console.log(error))
    }, [id]);

    return (
        <TableContainer>
            <Table size="small">
                <TableHead>
                    <TableRow>
                        <TableCell>日付</TableCell>
                        <TableCell>商品名</TableCell>
                        <TableCell align="right">単価</TableCell>
                        <TableCell align="right">数量</TableCell>
                        <TableCell align="right">合計額</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {sales.map((entry, index) => (
                        <TableRow key={index}>
                            <TableCell>{entry.date}</TableCell>
                            <TableCell>{entry.product}</TableCell>
                            <TableCell align="right">{entry.price}</TableCell>
                            <TableCell align="right">{entry.quantity}</TableCell>
                            <TableCell align="right">{`${NWC.format(entry.total)}`}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </TableContainer>
    );
}
