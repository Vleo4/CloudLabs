using Telegram.Bot.Types;
using Telegram.Bot;
using Telegram.Bot.Types.ReplyMarkups;

namespace am3bot.Controllers.Commands
{
    public class StartCommand : ICommand
    {
        public TelegramBotClient Client => Bot.GetTelegramBot().Result;

        public string Name => "/start";
        public async Task Execute(Update update)
        {
            long chatId = update.Message.Chat.Id;
            await Client.SendTextMessageAsync(
                chatId,
                text: "Choose an option:",
                replyMarkup: GetChessboardMainMenuKeyboard());
        }
        private ReplyKeyboardMarkup GetChessboardMainMenuKeyboard()
        {
            return new ReplyKeyboardMarkup(new List<KeyboardButton[]>
            {
        new KeyboardButton[] { new KeyboardButton("Спеціальності💀"), new KeyboardButton("Освітні програми🥃"), new KeyboardButton("Військова кафедра🐶") },
        new KeyboardButton[] { new KeyboardButton("Як добратися🚼"), new KeyboardButton("Офіційний сайт🍷") },
        new KeyboardButton[] { new KeyboardButton("Exit🌚") },
            })
            {
                ResizeKeyboard = true
            };

        }
    }
}
