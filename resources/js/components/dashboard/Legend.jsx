import * as React from "react";
import Checkbox from "@mui/material/Checkbox";
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableRow from '@mui/material/TableRow';
import StopIcon from "@mui/icons-material/Stop";
import { COLORS } from "../Styles";

export default function CustomLegend(props) {
    const numberWithComma = new Intl.NumberFormat();
    return (
        <Table size="small">
            <TableBody>
                {props.items.map((items, index) => (
                    <TableRow key={index} role="checkbox">
                        <TableCell padding="checkbox" style={{paddingLeft: 0, paddingRight: 0}}>
                            <Checkbox
                                disabled
                                size="small"
                                icon={
                                    <StopIcon style={{ color: COLORS[index % COLORS.length] }} />
                                }
                            />
                        </TableCell>
                        <TableCell component="th" scope="row" padding="none">
                            {items.name}
                        </TableCell>
                        <TableCell align="right">
                            ¥{numberWithComma.format(items.value)}
                        </TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}
