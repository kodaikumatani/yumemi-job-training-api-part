import * as React from 'react';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Title from './Title';
import { TableContainer } from "@mui/material";
import {useEffect, useState} from "react";
import axios from "axios";

function preventDefault(event) {
  event.preventDefault();
}

export default function SalesTable() {
    const NWC = new Intl.NumberFormat();
    const [sales, setSales] = useState([]);

    useEffect(() => {
        axios.get('/api/sales/daily/2023-02-06')
            .then(response => setSales(response.data.details))
            .catch(error => console.log(error))
    }, []);

    return (
        <React.Fragment>
            <Title>Recent Sales</Title>
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
                        {sales.map((row, index) => (
                            <TableRow key={index}>
                                <TableCell>{row.date}</TableCell>
                                <TableCell>{row.product}</TableCell>
                                <TableCell align="right">{row.price}</TableCell>
                                <TableCell align="right">{row.quantity}</TableCell>
                                <TableCell align="right">{`${NWC.format(row.total)}`}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
        </React.Fragment>
    );
}
