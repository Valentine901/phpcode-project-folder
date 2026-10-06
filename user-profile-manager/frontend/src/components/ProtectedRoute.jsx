import { useAuth } from "../context/AuthContext";
import { Navigate } from "react-router-dom";
import Loader from "./Loader";


const ProtectedRoute = ({ children }) => {
    const { user, loading } = useAuth();

    if (loading) {
        return <Loader />
    }

    if (user === null) {
        return <Navigate to="/auth/signin" replace />;
    }

    return children;
}

export default ProtectedRoute