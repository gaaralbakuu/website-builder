import { createTheme } from "@mui/material/styles";

// A custom theme for this app
const theme = createTheme({
  palette: {
    primary: {
      main: "#42a5f5",
      contrastText: "#fff"
    },
    secondary: {
      main: "#ba68c8",
    },
    error: {
      main: "#ef5350",
    },
    warning: {
      main: "#ff9800",
    },
    info: {
      main: "#03a9f4",
    },
    success: {
      main: "#4caf50",
    },
  },
  components: {
    MuiButton: {
      defaultProps: {
        disableElevation: true,
        variant: "contained",
      },
      styleOverrides: {
        root: {
          textTransform: "unset",
          borderRadius: 8
        },
      },
    },
    MuiFormControl: {
      styleOverrides: {
        root: {
          "& fieldset": {
            borderRadius: 8
          },
          "& .Mui-focused fieldset": {
            borderColor: "#000!important",
            borderWidth: "1px!important"
          },
          "& label.Mui-focused": {
            color: "#000!important"
          }
        }
      }
    }
  },
});

export default theme;
