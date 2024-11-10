import { setWidgetOption } from '@/entities/options/model/optionSlice';
import Stepper from '@/widgets/stepper/ui/Stepper';
import { useEffect } from 'react';
import { useDispatch } from 'react-redux';
import styles from './styles.module.scss';

const MainPage = ({ options }) => {
    const dispatch = useDispatch();

    useEffect(() => {
        if (options) {
            dispatch(setWidgetOption(options));
        }
    }, [options, dispatch]);

    return (
        <div className={styles.page}>
            <Stepper />
        </div>
    );
};

export default MainPage;
