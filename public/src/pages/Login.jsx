import {
  Box,
  Button,
  FormControl,
  OutlinedInput,
  Paper,
  styled,
  Typography,
} from "@mui/material";
import { blue, grey } from "@mui/material/colors";
import React, { Fragment } from "react";
import { NavLink } from "react-router-dom";

const PaperLogin = styled(Paper)(({ theme }) => ({
  maxWidth: theme.breakpoints.values.sm,
  width: "100%",
  padding: 40,
}));

const BoxLabelRegister = styled(Box)(() => ({
  display: "flex",
  gap: 4,
  marginTop: 16,
  marginBottom: 32,
  flexWrap: "wrap",
}));

const LinkRegister = styled(Typography)(({ theme }) => ({
  color: blue[500],
  fontWeight: 500,
  textDecoration: "none",
  "&:hover": {
    textDecoration: "underline",
  },
}));

function Login() {
  return (
    <PaperLogin>
      <Typography variant="h4" fontWeight={700}>
        Đăng nhập
      </Typography>
      <BoxLabelRegister>
        <Typography
          component={"span"}
          variant="body1"
          fontWeight={500}
          color={grey[600]}
        >
          Chưa có tài khoản?
        </Typography>{" "}
        <LinkRegister component={NavLink} to={"/"}>
          Tạo tài khoản
        </LinkRegister>
      </BoxLabelRegister>

      <Typography fontWeight={500} color={grey[700]}>
        Tài khoản
      </Typography>
      <FormControl
        variant="outlined"
        fullWidth={true}
        style={{ paddingTop: 8, paddingBottom: 16 }}
      >
        <OutlinedInput />
      </FormControl>
      <Typography fontWeight={500} color={grey[700]}>
        Mật khẩu
      </Typography>
      <FormControl
        variant="outlined"
        fullWidth={true}
        style={{ paddingTop: 8, paddingBottom: 16 }}
      >
        <OutlinedInput />
      </FormControl>
    </PaperLogin>
  );
}

export default Login;
