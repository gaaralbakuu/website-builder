import React from "react";
import { Box, styled } from "@mui/material";
import { Outlet } from "react-router-dom";

const BoxLayout = styled(Box)(({ theme }) => ({
  backgroundColor: theme.palette.secondary.main,
  height: "100%",
  display: "flex",
  justifyContent: "center",
  alignItems: "center",
  padding: 16
}));

function Layout() {
  return (
    <BoxLayout>
      <Outlet />
    </BoxLayout>
  );
}

export default Layout;
