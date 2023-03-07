import React, { useState } from 'react';
import { IconButton, Popover, TextField } from "@mui/material";
import InsertInvitationIcon from '@mui/icons-material/InsertInvitation';
import { LocalizationProvider } from "@mui/x-date-pickers";
import { AdapterDayjs } from "@mui/x-date-pickers/AdapterDayjs";
import { DateCalendar } from "@mui/x-date-pickers/DateCalendar";

export default function Calendar(props) {
    const { selected, setSelected } = props;
    const [anchorEl, setAnchorEl] = useState(null);
    const handleClick = (event) => {
        setAnchorEl(event.currentTarget);
    };
    const handleClose = () => {
        setAnchorEl(null);
    };
    const handleChoose = (value) => {
        setAnchorEl(null);
        setSelected(value);
    };
    const open = Boolean(anchorEl);
    const id = open ? 'simple-popover' : undefined;

    return (
        <TextField
            label="Date"
            value={selected.format('YYYY年MM月DD日')}
            InputProps={{
                readOnly: true,
                endAdornment: (
                    <>
                        <IconButton onClick={handleClick}>
                            <InsertInvitationIcon />
                        </IconButton>
                        <Popover
                            id={id}
                            open={open}
                            anchorEl={anchorEl}
                            onClose={handleClose}
                            anchorOrigin={{
                                vertical: 'bottom',
                                horizontal: 'left',
                            }}
                        >
                            <LocalizationProvider dateAdapter={AdapterDayjs}>
                                <DateCalendar value={selected} onChange={(newValue) => handleChoose(newValue)}/>
                            </LocalizationProvider>
                        </Popover>
                    </>
                ),
            }}
            variant="standard"
        />
    );
}
