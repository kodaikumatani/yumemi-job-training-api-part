import React, {useState} from 'react';
import dayjs from 'dayjs';
import {
    createTheme,
    ThemeProvider,
    CssBaseline,
    Box,
    Toolbar,
    Container,
    Grid,
    IconButton,
    Typography,
    AppBar,
} from '@mui/material';
import Stores from '../components/Stores'
import Products from "../components/Products";
import SalesStatus from "../components/SalesStatus";
import HourlySales from "../components/HourlySales";
import Calendar from "../components/Calendar";

const mdTheme = createTheme();

const Dashboard = () => {
    const [date, setDate] = useState(dayjs);

    return (
        <ThemeProvider theme={mdTheme}>
            <Box sx={{ display: 'flex' }}>
                <CssBaseline />
                <AppBar component="nav">
                    <Toolbar>
                        <Typography
                            variant="h6"
                            component="div"
                            sx={{ flexGrow: 1, display: { xs: 'none', sm: 'block' } }}
                        >
                            MUI
                        </Typography>
                    </Toolbar>
                </AppBar>
                <Box
                    component="main"
                    sx={{
                        backgroundColor: (theme) =>
                            theme.palette.mode === 'light'
                                ? theme.palette.grey[100]
                                : theme.palette.grey[900],
                        flexGrow: 1,
                        height: '100vh',
                        overflow: 'auto',
                    }}
                >
                    <Toolbar />
                    <Container maxWidth="lg" sx={{ mt: 4, mb: 4 }}>
                        <Grid container spacing={3}>
                            {/* Date */}
                            <Grid xs={12} container justifyContent="flex-end">
                                <Calendar selected={date} setSelected={setDate}/>
                            </Grid>
                            {/* Sales */}
                            <Grid item lg={5} xs={12}>
                                <Stores date={date.format('YYYY-MM-DD')} />
                            </Grid>
                            {/* HourlySales */}
                            <Grid item lg={7} xs={12}>
                                <HourlySales date={date.format('YYYY-MM-DD')} />
                            </Grid>
                            {/* Products */}
                            <Grid item lg={5} xs={12}>
                                <Products date={date.format('YYYY-MM-DD')} />
                            </Grid>
                            {/* SaleStatus */}
                            <Grid item lg={7} xs={12}>
                                <SalesStatus date={date.format('YYYY-MM-DD')} />
                            </Grid>
                        </Grid>
                    </Container>
                </Box>
            </Box>
        </ThemeProvider>
    );
}

export default Dashboard;