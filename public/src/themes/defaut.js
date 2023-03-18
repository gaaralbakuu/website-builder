import { createTheme } from "@mui/material";
import { green, grey } from "@mui/material/colors";

export default createTheme({
  palette: {
    primary: {
      main: green["A400"],
    },
    secondary: {
      main: grey[200],
    },
  },
  typography: {
    fontFamily: '"Inter", Helvetica, "sans-serif"',
  },
  components: {
    MuiPaper: {
      styleOverrides: {
        rounded: {
          borderRadius: 24,
        },
      },
      defaultProps: {
        variant: 0,
      },
    },
    MuiButton: {
      defaultProps: {
        disableElevation: true,
      },
      styleOverrides: {
        root: {
          textTransform: "inherit",
        },
      },
    },
    MuiOutlinedInput: {
      styleOverrides: {
        root: {
          "& fieldset": {
            borderRadius: 8,
            borderColor: grey[400],
            borderWidth: "1px!important",
          },
          "&:hover fieldset": {
            borderColor: grey[600]+"!important",
          },
          "&.Mui-focused fieldset": {
            borderColor: grey[600]+"!important",
          },
        },
      },
    },
  },
});
