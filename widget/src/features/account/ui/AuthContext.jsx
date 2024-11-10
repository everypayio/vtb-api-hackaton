import { createContext } from 'react';
import { useAuth } from '../model/useAuth';

const AuthContext = createContext();

const AuthContextProvider = ({ children }) => {
    const { stateId, isUserAuthorized, getStateId } = useAuth();

    return (
        <AuthContext.Provider value={{ stateId, isUserAuthorized, getStateId }}>
            {children}
        </AuthContext.Provider>
    );
};

export { AuthContext, AuthContextProvider };
