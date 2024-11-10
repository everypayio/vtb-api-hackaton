import { Button } from '@consta/uikit/Button';

const AuthButton = ({ goAuth }) => {
    return <Button label='Оплатить через Request-to-Pay (R2P)' onClick={goAuth} />;
};

export default AuthButton;
