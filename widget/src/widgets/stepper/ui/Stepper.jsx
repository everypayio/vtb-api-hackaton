import { useCallback, useContext, useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { nextStep, prevStep } from '../model/stepsSlice';
import { AuthContext } from '@/features/account/ui/AuthContext';
import AuthButton from '@/features/account/ui/AuthButton';
import Banks from '@/features/banks/ui/Banks';
import Payment from '@/features/payment/ui/Payment';
import Success from './Success';
import styles from '../styles/style.module.scss';

const Stepper = () => {
    const dispatch = useDispatch();

    const { currentStep, steps } = useSelector((state) => state.steps);
    const { currentConnectorData, connectorPayment } = useSelector((state) => state.connectors);

    const { isUserAuthorized, getStateId } = useContext(AuthContext);

    const handleNext = useCallback(() => {
        dispatch(nextStep());
    }, [dispatch]);

    const handlePrev = useCallback(() => {
        dispatch(prevStep());
    }, [dispatch]);

    useEffect(() => {
        if (isUserAuthorized) {
            handleNext();
        }
    }, [isUserAuthorized, handleNext]);

    useEffect(() => {
        if (currentConnectorData) {
            handleNext();
        }
    }, [currentConnectorData, handleNext]);

    useEffect(() => {
        if (connectorPayment) {
            handleNext();
        }
    }, [connectorPayment, handleNext]);

    const renderStep = () => {
        switch (steps[currentStep].component) {
            case 'Auth':
                return <AuthButton goAuth={getStateId} />;
            case 'Banks':
                return <Banks />;
            case 'Payment':
                return <Payment />;
            case 'Success':
                return <Success />;
            default:
                return null;
        }
    };

    return (
        <div className={styles.stepper}>
            {renderStep()}
            {/* <button onClick={handlePrev} disabled={currentStep === 0}>
                Назад
            </button>
            <button onClick={handleNext} disabled={currentStep === steps.length - 1}>
                Вперед
            </button> */}
        </div>
    );
};

export default Stepper;
