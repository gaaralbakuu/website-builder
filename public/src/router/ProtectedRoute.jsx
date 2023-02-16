import { useEffect } from "react";
import { Outlet, useNavigate } from "react-router-dom";

export default (first) => {
  const navigate = useNavigate();
  const user = "";

  useEffect(() => {
    if (!user) {
      navigate("/login");
    }
  }, [user]);

  return <Outlet />;
};
