import { Visibility, VisibilityOff } from "@mui/icons-material";
import {
  Box,
  styled,
  Typography,
  Link as MuiLink,
  TextField,
  IconButton,
  InputAdornment,
  OutlinedInput,
  InputLabel,
  FormControl,
  Button,
} from "@mui/material";
import { useState } from "react";
import { Link } from "react-router-dom";

const CustomBox = styled(Box)(({ theme }) => ({
  maxWidth: 480,
  width: "100%",
}));

const CustomLink = styled(MuiLink)(({ theme }) => ({
  color: theme.palette.success.main,
}));

const CustomButton = styled(Button)(({ theme }) => ({
  backgroundColor: "rgb(33, 43, 54)",
  "&:hover": {
    backgroundColor: "rgb(33, 43, 54)"
  }
}));

export default () => {
  const [showPassword, setShowPassword] = useState(false);

  const handleClickShowPassword = () => setShowPassword((show) => !show);

  const handleMouseDownPassword = (event) => {
    event.preventDefault();
  };

  return (
    <Box flex={1} display={"flex"} justifyContent="center" alignItems="center">
      <CustomBox>
        <Box display={"flex"} flexDirection={"column"} mb={5}>
          <Typography variant={"h5"} fontWeight={700}>
            Sign in to Manager
          </Typography>
          <Typography variant="body2" mt={2}>
            <Box display={"flex"}>
              <Box>New users?</Box>
              <Box>
                <CustomLink
                  component={Link}
                  to={"/register"}
                  fontWeight={700}
                  ml={0.5}
                  underline={"hover"}
                >
                  Create an account
                </CustomLink>
              </Box>
            </Box>
          </Typography>
        </Box>
        <Box display={"flex"} flexDirection={"column"}>
          <Box>
            <TextField
              variant={"outlined"}
              label={"Email address"}
              fullWidth={true}
            />
          </Box>
          <Box sx={{ mt: 3 }}>
            <FormControl fullWidth={true} variant={"outlined"}>
              <InputLabel htmlFor={"outlined-adornment-password"}>
                Password
              </InputLabel>
              <OutlinedInput
                id={"outlined-adornment-password"}
                type={showPassword ? "text" : "password"}
                endAdornment={
                  <InputAdornment position={"end"}>
                    <IconButton
                      aria-label={"toggle password visibility"}
                      onClick={handleClickShowPassword}
                      onMouseDown={handleMouseDownPassword}
                      edge={"end"}
                    >
                      {showPassword ? (
                        <VisibilityOff fontSize={"small"} />
                      ) : (
                        <Visibility fontSize={"small"} />
                      )}
                    </IconButton>
                  </InputAdornment>
                }
                label={"Password"}
              />
            </FormControl>
          </Box>
        </Box>
        <Box
          display={"flex"}
          flexDirection={"row"}
          justifyContent={"space-between"}
          my={2}
        >
          <Box></Box>
          <MuiLink component={Link} to={"auth/forgot"} color={"#000"}>
            <Typography variant={"body2"}>Forgot password?</Typography>
          </MuiLink>
        </Box>
        <Box>
          <CustomButton size={"large"} fullWidth={true}>
            Login
          </CustomButton>
        </Box>
      </CustomBox>
    </Box>
  );
};
