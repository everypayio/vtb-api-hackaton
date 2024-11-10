import { Text } from '@consta/uikit/Text';
import { Button } from '@consta/uikit/Button';
import { CheckboxGroup } from '@consta/uikit/CheckboxGroup';
import { useSelector } from 'react-redux';
import { useCreatePaymentMutation } from '@/entities/connectors/api';
import { useCallback, useEffect, useState } from 'react';
import styles from '../styles/styles.module.scss';

const Payment = () => {
    const [paymentData, setpaymentData] = useState({});
    const [bankAccount, setBankAccount] = useState(null);
    const [debtorAccountId, setDebtorAccountId] = useState();
    const { currentConnectorData, connectorId } = useSelector((state) => state.connectors);
    const { payeeData } = useSelector((state) => state.account);
    const { widgetOption } = useSelector((state) => state.option);
    const [createPayment] = useCreatePaymentMutation();

    const sendPayment = useCallback(async () => {
        await createPayment({ id: paymentData.connectorId, body: paymentData.body });
    }, [createPayment, paymentData]);

    const handleCheck = useCallback(({ account, item }) => {
        setDebtorAccountId(account.accountId);
        setBankAccount(item);
    }, []);

    const handleDisableCheckbox = useCallback(
        (item) => {
            return bankAccount?.length === 1 && !bankAccount.includes(item);
        },
        [bankAccount],
    );

    useEffect(() => {
        if (currentConnectorData && connectorId) {
            setpaymentData({
                connectorId: connectorId,
                body: {
                    debtorAccountId: debtorAccountId,
                },
            });
        }
    }, [debtorAccountId, connectorId, currentConnectorData]);

    const renderedBankAccount = () => {
        if (currentConnectorData) {
            return currentConnectorData.Data.Account.map((account) => (
                <div className={styles.item} key={Math.floor(Math.random() * 1000000)}>
                    {account?.Owner?.name && (
                        <Text className={styles.item} weight='medium' size='m'>
                            {account.Owner.name}
                        </Text>
                    )}
                    <CheckboxGroup
                        value={bankAccount}
                        items={account.AccountDetails}
                        getItemLabel={(item) => item.name}
                        getItemDisabled={handleDisableCheckbox}
                        onChange={(item) => handleCheck({ account, item })}
                    />
                </div>
            ));
        }
    };

    return (
        <div className={styles.wrap}>
            <Text weight='semibold' size='2xl'>
                Детали платежа
            </Text>
            <div className={styles.list}>
                <div className={styles.list}>
                    <Text className={styles.item} weight='medium' size='l'>
                        Выберите счет:
                    </Text>
                    {renderedBankAccount()}
                </div>
                <Text weight='medium' size='l'>
                    Сумма платежа:
                    <Text weight='light' size='m'>
                        {widgetOption?.amount} {widgetOption?.currency}
                    </Text>
                </Text>
                <Text weight='medium' size='l'>
                    Назначение платежа:
                    <Text weight='light' size='m'>
                        {widgetOption?.purpose}
                    </Text>
                </Text>
            </div>
            {payeeData && (
                <div className={styles.list}>
                    <Text weight='semibold' size='xl'>
                        Получатель
                    </Text>
                    <Text weight='medium' size='l'>
                        Огранизация:
                        <Text weight='light' size='m'>
                            {payeeData?.payee?.name}
                        </Text>
                    </Text>
                    {payeeData?.payeeAgent?.name && (
                        <Text weight='medium' size='l'>
                            Банк:
                            <Text weight='light' size='m'>
                                {payeeData?.payeeAgent?.name}
                            </Text>
                        </Text>
                    )}
                    <Text weight='medium' size='l'>
                        Л/С:
                        <Text weight='light' size='m'>
                            {payeeData?.payeeAccount}
                        </Text>
                    </Text>
                    <Text weight='medium' size='l'>
                        Бик:
                        <Text weight='light' size='m'>
                            {payeeData?.payeeAgent.bic}
                        </Text>
                    </Text>
                </div>
            )}

            <Button label='Отправить' onClick={sendPayment} disabled={!bankAccount} />
        </div>
    );
};

export default Payment;
