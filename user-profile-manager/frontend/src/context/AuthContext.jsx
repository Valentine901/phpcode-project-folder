import { useState, useEffect, useCallback, useContext, createContext } from "react";
import { API } from "../constants/API";
import { useNavigate } from "react-router-dom";


const AuthContextContainer = createContext();

const AuthContextProvider = ({ children }) => {
    const [user, setUser] = useState(() => JSON.parse(localStorage.getItem("user")) || null);
    // () => JSON.parse(localStorage.getItem("user")) || null
    const [loading, setLoading] = useState(false);
    const [profileLoading, setProfileLoading] = useState(false);
    const [profile, setProfile] = useState(() => {
        const saved = localStorage.getItem("profile");
        return saved !== null ? JSON.parse(saved) : null  
    });

    const [error, setError] = useState("");
    const navigate = useNavigate();

    // save logged in user to localstorage
    const SaveUser = (value) => {
        localStorage.setItem("user", JSON.stringify(value));
        setUser(value);
    }

    const AxiosErrorHandler = (error) => {
        if (error.response) {
            setError(error.response.data.message);
            console.log(error.response.data.message);
        } else if (error.request) {
            setError("Unable to connect to the server");
        } else {
            setError("Something went wrong");
        }
    }

    const RefreshToken = async () => {

        try {
            await API.get("/auth/refresh-token.php");
            await GetCurrentUser();
            return true;

        } catch (error) {
            AxiosErrorHandler(error);
            return false;
        } finally {
            setLoading(false);
        }
    }

    const GetCurrentUser = async () => {

        try {
            const response = await API.get("/auth/get-current-user.php");
            SaveUser(response.data);

            return true;

        } catch (error) {
            localStorage.removeItem("user");
            setUser(null);
            AxiosErrorHandler(error);
            return false;
        } finally {
            setLoading(false);
        }
    }


    const Logout = async () => {
        setLoading(true);
        setError("");

        try {
            await API.post("/auth/logout.php");
            navigate("/auth/signin");

        } catch (error) {
            AxiosErrorHandler(error);
        } finally {
            localStorage.removeItem("user");
            setUser(null);
            setLoading(false);
            navigate("/auth/signin");
        }
    }

    const fetchProfile = async () => {
        setProfileLoading(true);
        setError('');

        try{
            const response = await API.get("/profile/fetch-profile.php");
            localStorage.setItem("profile", JSON.stringify(response.data));
            setProfile(response.data)
        } catch (error) {
            AxiosErrorHandler(error);
        } finally{
            setProfileLoading(false);
        }
    }

    useEffect(() => {
        const InitializeAuth = async () => {
            setLoading(true);
            try {
                let isUserValid = await GetCurrentUser();

                if (!isUserValid) {
                    const refreshed = await RefreshToken();
                    if (refreshed) isUserValid = await GetCurrentUser();
                }
                if (isUserValid) await fetchProfile();

            } catch (error) {
                localStorage.removeItem("user");
                setUser(null);
            } finally {
                setLoading(false);
            }
        };
        InitializeAuth();
    }, [])

    // useEffect(() => {
        
    // }, [])

    return <AuthContextContainer value={{ user, setUser, loading, error, GetCurrentUser, SaveUser, AxiosErrorHandler, Logout, profile, fetchProfile, profileLoading }}>
        {children}
    </AuthContextContainer>
}

export default AuthContextProvider;
export const useAuth = () => useContext(AuthContextContainer);