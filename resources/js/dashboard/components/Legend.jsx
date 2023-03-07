import React from 'react';
import {
    Checkbox,
    Table,
    TableBody,
    TableCell,
    TableRow
} from '@mui/material';
import StopIcon from '@mui/icons-material/Stop';
import { COLORS } from '../../layouts/Styles';

const Legend = (props) => {
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
export default Legend;
