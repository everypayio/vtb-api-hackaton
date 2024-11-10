import { Text } from '@consta/uikit/Text';
import styles from '../styles/style.module.scss';

const Success = () => {
    return (
        <Text view='success' size='l' weight='semibold' className={styles.success}>
            Спасибо, ваш платеж отправлен в банк. <br />
            Пожалуйста, перейдите в банк-клиент для подписания платежа.
        </Text>
    );
};

export default Success;
