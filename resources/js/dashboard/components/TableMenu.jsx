import React, { useState } from 'react';
import { Box, IconButton, Menu, MenuItem, Typography } from '@mui/material';
import MoreVertIcon from '@mui/icons-material/MoreVert';

const TableMenu = (props) => {
    const { store, select, setSelect } = props;
    const [anchorEl, setAnchorEl] = useState(null);
    const open = Boolean(anchorEl);
    const handleClick = (event) => {
        setAnchorEl(event.currentTarget);
    };
    const handleClose = () => {
        setAnchorEl(null);
    };
    const handleChoose = (id) => {
        setAnchorEl(null);
        setSelect(id);
    };

    return (
        <Box>
            <IconButton
                aria-label="more"
                id="long-button"
                aria-controls={open ? 'long-menu' : undefined}
                aria-expanded={open ? 'true' : undefined}
                aria-haspopup="true"
                onClick={handleClick}
            >
                <MoreVertIcon />
            </IconButton>
            <Menu
                id="long-menu"
                MenuListProps={{
                    'aria-labelledby': 'long-button',
                }}
                anchorEl={anchorEl}
                open={open}
                onClose={handleClose}
            >
                {store.map((entry) => (
                    <MenuItem
                        key={entry.id}
                        selected={entry.id === select}
                        onClick={(e) => handleChoose(entry.id, e)}
                    >
                        <Typography>{entry.name}</Typography>
                    </MenuItem>
                ))}
            </Menu>
        </Box>
    );
}
export default TableMenu;
