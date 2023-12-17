using Telegram.Bot.Types;
using Telegram.Bot;

namespace am3bot.Controllers.Commands
{
    public class HowToGetThereCommand : ICommand
    {
        public TelegramBotClient Client => Bot.GetTelegramBot().Result;

        public string Name => "Як добратися🚼";

        public async Task Execute(Update update)
        {
            long chatId = update.Message.Chat.Id;

            await Client.SendTextMessageAsync(
                chatId,
                text: "вулиця Князя Романа, 5, Львів, Львівська область, 79000");
        }
    }
}
