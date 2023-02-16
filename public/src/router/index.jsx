import { Box } from "@mui/material";
import { createBrowserRouter, Outlet } from "react-router-dom";

// Route Element
import Home from "../pages/Home";
import Login from "../pages/Login";
import ManagerHome from "../pages/manager/Home";
import ManagerLayout from "../pages/manager/Layout";
import ProtectedRoute from "./ProtectedRoute";

const AuthLayout = () => {
  return (
    <Box sx={{ display: "flex", width: "100%", height: "100%" }}>
      <Outlet />
    </Box>
  );
};

export default createBrowserRouter([
  {
    element: <AuthLayout />,
    children: [
      {
        element: <Home />,
        path: "/",
      },
      {
        element: <Login />,
        path: "/login",
      },

      // manager
      {
        element: <ProtectedRoute />,
        children: [
          {
            element: <ManagerLayout />,
            path: "/manager",
            children: [
              {
                element: <ManagerHome />,
                index: true,
              },
            ],
          },
        ],
      },
    ],
  },
]);
